<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Fallas</title>
    <style>
        /* Mantén solo estilos compatibles con DOMPDF */
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; }
        .titulo { color: #2c3e50; font-size: 24px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th { background-color: #2c3e50; color: white; padding: 10px; text-align: left; }
        td { padding: 8px; border: 1px solid #ddd; }
        .estadisticas { margin-top: 30px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="titulo">Reporte de Fallas</h1>
        <p>Generado el: <?= date('d/m/Y H:i') ?></p>
        <p>Período: <?= date('d/m/Y', strtotime($filtros['fechaInicio'])) ?> - <?= date('d/m/Y', strtotime($filtros['fechaFin'])) ?></p>
    </div>

    <!-- Tabla de estadísticas simplificada para PDF -->
    <?php foreach ($estadisticas as $categoria => $datos): ?>
        <?php if (!empty($datos)): ?>
            <div class="estadisticas">
                <h3>Fallas por <?= ucfirst($categoria) ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th><?= ucfirst($categoria) ?></th>
                            <th>Cantidad</th>
                            <th>Porcentaje</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total = array_sum($datos);
                        arsort($datos);
                        foreach ($datos as $nombre => $cantidad): 
                            $porcentaje = ($cantidad / $total) * 100;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($nombre) ?></td>
                                <td><?= $cantidad ?></td>
                                <td><?= number_format($porcentaje, 2) ?>%</td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
</body>
</html>