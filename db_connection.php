<?php
// db_connection.php

$servername = "localhost";  // Servidor de banco de dados (geralmente localhost)
$username = "root";  // Seu usuário do banco de dados
$password = "";    // Sua senha do banco de dados
$dbname = "blog";   // Nome do banco de dados

// Cria a conexão inicial sem selecionar o banco de dados
$conn = new mysqli($servername, $username, $password);

// Verifica a conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verifica se o banco de dados existe
$db_check = $conn->query("SHOW DATABASES LIKE '$dbname'");
if ($db_check->num_rows == 0) {
    // Se o banco não existir, cria o banco de dados usando o arquivo blog.sql
    $sqlFile = __DIR__ . '/blog.sql'; // Caminho para o arquivo SQL
    $sql = file_get_contents($sqlFile);

    if ($conn->multi_query($sql)) {
        echo "Banco de dados 'blog' criado com sucesso!";
    } else {
        die("Erro ao criar o banco de dados: " . $conn->error);
    }
}

// Seleciona o banco de dados
$conn->select_db($dbname);
?>
