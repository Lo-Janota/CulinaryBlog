<?php

require_once 'Post.php';
require_once 'Comment.php';

class CommentHandler
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Método para processar o comentário
    public function processComment($postIndex, $user, $commentText) {
        // Verifica se o post existe na sessão
        if (isset($_SESSION['posts'][$postIndex])) {
            // Cria o novo comentário
            $newComment = new Comment($user, $commentText);

            // Adiciona o comentário ao post
            $_SESSION['posts'][$postIndex]->addComment($newComment);

            // Redireciona para a página principal
            $this->redirect('../index.php');
        } else {
            throw new Exception("Post não encontrado.");
        }
    }

    // Método para redirecionar a página
    private function redirect($url) {
        header("Location: $url");
        exit;
    }
}

