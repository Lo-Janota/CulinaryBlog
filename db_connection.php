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
    // Se o banco de dados não existir, cria o banco
    $createDbQuery = "CREATE DATABASE `$dbname`";
    if ($conn->query($createDbQuery) === TRUE) {
        // Exibe um alerta e recarrega a página após o clique
        echo "<script>
                alert('BANCO DE DADOS \"$dbname\" CRIADO COM SUCESSO!');
                window.location.reload(); // Recarrega a página
              </script>";

        // Agora, seleciona o banco de dados recém-criado
        $conn->select_db($dbname);

        // Caminho para o arquivo SQL
        $sqlFile = __DIR__ . '/blog.sql'; // Certifique-se de que o arquivo blog.sql esteja no mesmo diretório

        // Lê o conteúdo do arquivo SQL
        $sql = file_get_contents($sqlFile);

        // Executa as queries do arquivo SQL
        if ($conn->multi_query($sql)) {
            // As tabelas foram criadas com sucesso
        } else {
            die("Erro ao executar o SQL: " . $conn->error);
        }
    } else {
        die("Erro ao criar o banco de dados: " . $conn->error);
    }
} else {
    // Se o banco de dados já existir, apenas seleciona
    $conn->select_db($dbname);
}
?>
