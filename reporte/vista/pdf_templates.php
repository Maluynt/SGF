<!DOCTYPE html>
<html>
<head>
    <style>
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f8f9fa; }
        .priority-indicator { 
            width: 15px; 
            height: 15px; 
            display: inline-block; 
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <h2>Reporte de Fallas</h2>
    <?php if(!empty($filtros)): ?>
    <p>Filtros aplicados: <?= http_build_query($filtros, '', ', ') ?></p>
    <?php endif; ?>
    
    <table>
        <thead>
            <tr>
                <?php foreach($allowedFields as $titulo => $campo): ?>
                <th><?= $titulo ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fallas as $falla): ?>
            <tr>
                <?php foreach($allowedFields as $titulo => $campo): ?>
                <td>
                    <?= htmlspecialchars($falla[$campo] ?? 'N/A') ?>
                    <?php if($campo === 'nombre_prioridad' && isset($falla['color_prioridad'])): ?>
                    <div class="priority-indicator" 
                         style="background-color: <?= $falla['color_prioridad'] ?>"></div>
                    <?php endif; ?>
                </td>
                <?php endforeach; ?>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>