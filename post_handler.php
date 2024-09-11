<?php
require_once 'classes/Post.php';
require_once 'classes/Comment.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}

// Simulando um armazenamento em sessão (memória)
if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];

    // Simulação de upload de imagem (apenas salvar o nome do arquivo)
    move_uploaded_file($_FILES['image']['tmp_name'], 'assets/images/' . $image);

    $newPost = new Post($title, $content, $image);
    $_SESSION['posts'][] = $newPost;

    header('Location: index.php');
    exit;
}
?>
