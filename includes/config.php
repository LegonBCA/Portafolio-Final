<?php
define('APP_NAME', 'Portafolio Personal');

$host = "localhost";
$db = "portafolio_db";  
$user = "root";
$pass = "";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$conn->set_charset("utf8");
?> 