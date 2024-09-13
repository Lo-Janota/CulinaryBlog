<?php

require_once '../classes/PostHandler.php';  // Caminho corrigido

// Verifica se a requisição é do tipo POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];

    // Instancia a classe PostHandler
    $postHandler = new PostHandler();

    // Tenta deletar o post
    try {
        $postHandler->deletePost($postIndex);
        $postHandler->redirect('../index.php');  // Redireciona de volta para a página principal
    } catch (Exception $e) {
        // Em caso de erro, exibe a mensagem de erro
        echo 'Erro: ' . $e->getMessage();
    }
}
?>
