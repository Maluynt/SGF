<?php
// Función para cargar configuración
function get_sidebar_config() {
    static $config = null;
    if($config === null) {
        $config = require __DIR__ . '/../config/siderbar_config.php';
    }
    return $config;
}

// Verificar ítem activo
function is_menu_active($menuKey) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $config = get_sidebar_config();
    return ($config[$menuKey]['link'] ?? '') === $currentPath;
}

// Verificar subítem activo
function is_submenu_active($subKey) {
    // Implementar lógica según tu estructura de rutas
    return false; // Personalizar según necesidad
}
?>