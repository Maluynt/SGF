<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/Administrador/modelo/modelo.php';

try {
   
    $modelo = new ServicioModel($pdo);
    
    $serviciosBD = $modelo->getServiciosBD();
    $servicios = $modelo->getServiciosEstaticos();
    
    $idsBD = array_values($serviciosBD);
    $serviciosValidos = [];
    $errores = [];
    $advertencias = [];
    foreach ($servicios as $servicio) {
        $nombreOriginal = $servicio['nombre'];
        $idStatic = $servicio['id'];
        $nombreBuscado = mb_strtolower(trim($nombreOriginal), 'UTF-8');
        $encontrado = false;
        $conflictoId = false;
    
        foreach ($serviciosBD as $nombreBD => $idBD) {
            $nombreBDNormalizado = mb_strtolower(trim($nombreBD), 'UTF-8');
            
            if ($nombreBDNormalizado === $nombreBuscado) {
                $servicio['id'] = $idBD; // Usar siempre el ID de BD
                $serviciosValidos[] = $servicio;
                $encontrado = true;
                break; // Eliminado el chequeo de diferencia de IDs
            }
        }
    
        if (!$encontrado) {
            if (in_array($idStatic, $idsBD)) {
                $errores[] = "El ID $idStatic está siendo usado por otro servicio en BD";
                $conflictoId = true;
            } else {
                $errores[] = "El servicio '$nombreOriginal' no existe en BD";
            }
        }
    }

    if (!empty($errores)) {
        throw new Exception("<strong>Problemas detectados:</strong><br>" . implode("<br>", $errores));
    }

} catch (PDOException $e) {
    $errorMessage = "Error de base de datos: " . htmlspecialchars($e->getMessage());
} catch (Exception $e) {
    $errorMessage = htmlspecialchars($e->getMessage());
}

// Pasar variables a la vista
$viewData = [
    'errorMessage' => $errorMessage ?? null,
    'serviciosValidos' => $serviciosValidos ?? [],
    'advertencias' => $advertencias ?? []
];

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/Administrador/vistas/index.php';


