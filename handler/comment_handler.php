<?php

require_once '../classes/CommentHandler.php';

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];  // Obtém o índice do post correto
    $user = $_POST['user'];
    $commentText = $_POST['comment'];

    // Instancia a classe CommentHandler
    $commentHandler = new CommentHandler();

    // Processa o comentário
    try {
        $commentHandler->processComment($postIndex, $user, $commentText);
    } catch (Exception $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
