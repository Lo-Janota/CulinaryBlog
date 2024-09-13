<?php

require_once '../classes/PostHandler.php';


// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Instancia a classe PostHandler
    $postHandler = new PostHandler();

    // Lida com o upload das imagens
    $images = $postHandler->handleImages($_FILES['images']);

    // Cria um novo post
    $postHandler->createPost($title, $content, $images);

    // Redireciona de volta para a página principal
    $postHandler->redirect('../index.php');
}
?>
