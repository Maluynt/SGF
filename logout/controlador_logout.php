<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/metro/SGF/logout/auth.php';

// Destruir toda la información de la sesión
$_SESSION = array();

// Borrar la cookie de sesión
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}

session_destroy();
header('Location: /metro/SGF/login/index.php?logout=1');
exit;
?>