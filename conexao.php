<?php
$servername = "localhost";
$username = "root"; // ou outro usuário
$password = "";     // ou a senha definida
$dbname = "escola";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
