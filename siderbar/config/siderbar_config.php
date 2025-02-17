<?php
// Configuración de menú (en /config/sidebar_config.php)
return [
    'user_info' => [
        'title' => 'Información de usuario',
        'icon' => 'fas fa-user-circle',
        'submenu' => [
            'perfil' => [
                'title' => 'Perfil: ' . ($_SESSION['id_perfil'] ?? ''),
                'icon' => 'fas fa-id-card'
            ],
            'carnet' => [
                'title' => 'Carnet: ' . ($_SESSION['usuario'] ?? ''),
                'icon' => 'fas fa-address-card'
            ],
            'nombre' => [
                'title' => 'Nombre: ' . ($_SESSION['nombre'] ?? ''),
                'icon' => 'fas fa-signature'
            ]
        ]
    ],
    'gestion' => [
        'title' => 'Gestionar',
        'icon' => 'fas fa-tasks',
        'submenu' => [
            'fallas' => [
                'title' => 'Fallas',
                'icon' => 'fas fa-exclamation-triangle',
                'link' => '/gestion/fallas'
            ],
            'registros' => [
                'title' => 'Registros',
                'icon' => 'fas fa-clipboard-list',
                'link' => '/gestion/registros'
            ]
        ]
    ],
    'menu_items' => [
        'descargas' => [
            'title' => 'Descargas',
            'icon' => 'fas fa-download',
            'link' => '/descargas'
        ],
        'historial' => [
            'title' => 'Historial',
            'icon' => 'fas fa-history',
            'link' => '/historial'
        ],
        'ayuda' => [
            'title' => 'Ayuda',
            'icon' => 'fas fa-question-circle',
            'link' => '/ayuda'
        ],
        'salir' => [
            'title' => 'Salir',
            'icon' => 'fas fa-sign-out-alt',
            'link' => '/logout',
            'class' => 'logout-item' // Clase adicional para estilos especiales
        ]
    ]
];