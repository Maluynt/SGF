<?php
// Contraseña en texto plano ingresada por el usuario
$password_input = "Metro123";

// Hash almacenado en la base de datos
$hash_almacenado = '$2y$10$b/N2TPCmiP.ZSI63tF7QMOA1bsV8VSVCMXLBLD8W2NxhYp3S.Xajq'; // Reemplaza con tu hash real

if (password_verify($password_input, $hash_almacenado)) {
    echo "¡La contraseña es válida!";
} else {
    echo "Contraseña incorrecta o hash inválido.";
}
?>