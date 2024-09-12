<?php
session_start();
require_once 'classes/Post.php';

// Simulando armazenamento em sessão
if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Processamento de múltiplas imagens
    $imageNames = [];
    $imageDir = 'assets/images/'; // Diretório onde as imagens serão salvas

    if (!empty($_FILES['images'])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $imageName = basename($_FILES['images']['name'][$key]);
            $targetFile = $imageDir . $imageName;

            // Move o arquivo para o diretório de imagens
            if (move_uploaded_file($tmp_name, $targetFile)) {
                $imageNames[] = $imageName; // Armazena o nome da imagem no array
            }
        }
    }

    // Cria um novo post com várias imagens
    $newPost = new Post($title, $content, $imageNames);
    $_SESSION['posts'][] = $newPost;

    header('Location: index.php');
    exit;
}
?>
