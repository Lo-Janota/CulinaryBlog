<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];

    // Remove o post com o índice especificado
    if (isset($_SESSION['posts'][$postIndex])) {
        unset($_SESSION['posts'][$postIndex]);
        // Reindexa o array de posts para evitar problemas de índices
        $_SESSION['posts'] = array_values($_SESSION['posts']);
    }

    // Redireciona de volta para a página principal
    header('Location: index.php');
    exit;
}
?>
