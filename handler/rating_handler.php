<?php

require_once '../classes/PostHandler.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];  // Obtém o índice do post correto
    $rating = (int) $_POST['rating'];   // Converte a avaliação para inteiro

    // Instancia a classe PostHandler
    $postHandler = new PostHandler();

    // Adiciona a avaliação ao post
    try {
        $postHandler->addRating($postIndex, $rating);
        $postHandler->redirect('../index.php');  // Redireciona de volta para a página principal
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
