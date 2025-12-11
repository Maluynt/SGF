<!DOCTYPE html>
<html>
<head>
    <style>
        @page { margin: 100px 25px; }
        header { 
            position: fixed; 
            top: -70px; 
            left: 0px; 
            right: 0px; 
            height: 70px; 
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }
        .table-primary {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .table-primary th {
            background-color: rgb(141, 141, 141);
            color: black;
            padding: 8px;
            border: 1px solid #dee2e6;
            text-align: left;
        }
        .table-primary td {
            padding: 6px;
            border: 1px solid #dee2e6;
        }
        .priority-indicator {
            width: 12px;
            height: 12px;
            display: inline-block;
            margin-left: 5px;
            border-radius: 50%;
        }
        .section-title {
            background-color: #e9ecef;
            padding: 6px;
            margin: 15px 0;
            font-weight: bold;
        }
        .logo {
            max-width: 100px;
            height: auto;
            display: block;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <header>
    <div class="logo-container">
    <?php
           
           $imagePath = $_SERVER['DOCUMENT_ROOT'].'/metro/SGF/img/logo_mlte.png';
           if(file_exists($imagePath)) {
               $imageData = base64_encode(file_get_contents($imagePath));
               echo '<img src="data:image/png;base64,'.$imageData.'" 
                    class="logo" 
                    alt="Logo Metro">';
           }
          
           ?>
           <h1>Metro Los Teques</h1>
       </div>
    </header>

    <h4 style="text-align: center; margin-bottom: 20px;">Reporte Detallado de Fallas</h4>
    
    <?php if(!empty($filtros)): ?>
    <div style="margin-bottom: 15px; padding: 10px; border: 1px solid #dee2e6; background-color: #f8f9fa;">
        <strong>Filtros aplicados:</strong><br>
        <?php foreach($filtros as $key => $value): ?>
            <?php if(!empty($value)): ?>
            • <?= ucfirst(str_replace('_', ' ', $key)) ?>: <?= htmlspecialchars($value) ?><br>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

    <?php 
    // Dividir campos en dos grupos
    $firstTableFields = array_slice($allowedFields, 0, 9, true);
    $secondTableFields = array_slice($allowedFields, 9, null, true);
    ?>

    <!-- Primera tabla -->
    <div class="section-title">Información Principal Parte 1</div>
    <table class="table-primary">
        <thead>
            <tr>
                <?php foreach($firstTableFields as $titulo => $campo): ?>
                <th><?= $titulo ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fallas as $falla): ?>
            <tr>
                <?php foreach($firstTableFields as $titulo => $campo): ?>
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

    <!-- Segunda tabla -->
    <div class="section-title">Información Principal Parte 2</div>
    <table class="table-primary">
        <thead>
            <tr>
                <?php foreach($secondTableFields as $titulo => $campo): ?>
                <th><?= $titulo ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php foreach($fallas as $falla): ?>
            <tr>
                <?php foreach($secondTableFields as $titulo => $campo): ?>
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

    <div style="position: fixed; bottom: -60px; left: 0px; right: 0px; height: 50px; text-align: center;">
        <hr style="border-top: 1px solid #dee2e6;">
        <div style="font-size: 8px; color: #6c757d;">
            Generado el <?= date('d/m/Y H:i') ?> | Sistema de Gestión de Fallas - Metro de Los Teques
        </div>
    </div>
</body>
</html>


