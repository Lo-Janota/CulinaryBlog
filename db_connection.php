<?php
// db_connection.php

$servername = "localhost";  // Servidor de banco de dados (geralmente localhost)
$username = "root";  // Seu usuário do banco de dados
$password = "";    // Sua senha do banco de dados
$dbname = "blog";   // Nome do banco de dados

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
