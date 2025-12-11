<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';
verificarAutenticacion();


require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/conexion/conexion_bd.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/Administrador/modelo/modelo.php';

try {
    $modelo = new ServicioModel($pdo);
    
    $serviciosBD = $modelo->getServiciosBD();
    $servicios = $modelo->getServiciosEstaticos();
    
    $serviciosValidos = [];
    $errores = [];
    $advertencias = [];
    
    // Crear array de IDs existentes en BD para validación
    $idsBD = array_values($serviciosBD);
    
    foreach ($servicios as $servicio) {
        $nombreOriginal = $servicio['nombre'];
        $idStatic = $servicio['id'];
        $nombreBuscado = mb_strtolower(trim($nombreOriginal), 'UTF-8');
        $encontradoEnBD = false;

        // Buscar por nombre normalizado en BD
        foreach ($serviciosBD as $nombreBD => $idBD) {
            $nombreBDNormalizado = mb_strtolower(trim($nombreBD), 'UTF-8');
            
            if ($nombreBDNormalizado === $nombreBuscado) {
                // Coincidencia por nombre - usar ID de BD
                $servicioValido = $servicio;
                $servicioValido['id'] = $idBD;
                
                // Verificar si el ID estático es diferente
                if ($idStatic != $idBD) {
                    $advertencias[] = "El servicio '$nombreOriginal' usa ID de BD ($idBD) diferente al estático ($idStatic)";
                }
                
                $serviciosValidos[] = $servicioValido;
                $encontradoEnBD = true;
                break;
            }
        }

        if (!$encontradoEnBD) {
            // Si no se encontró por nombre, validar ID estático
            if (in_array($idStatic, $idsBD)) {
                $errores[] = "Conflicto de ID: El ID $idStatic (para '$nombreOriginal') ya está en uso por otro servicio";
            } else {
                // Permitir servicio con ID estático pero registrar advertencia
                $advertencias[] = "Servicio '$nombreOriginal' no encontrado en BD - Usando ID estático ($idStatic)";
                $serviciosValidos[] = $servicio;
            }
        }
    }

    if (!empty($errores)) {
        throw new Exception("<strong>Problemas críticos:</strong><br>" . implode("<br>", $errores));
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
$esVistaSegura = true; // Bandera de seguridad
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/Administrador/vistas/index.php';