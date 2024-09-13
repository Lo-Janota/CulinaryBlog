<?php

require_once 'Post.php';

class PostHandler
{
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Garante que o array de posts exista na sessão
        if (!isset($_SESSION['posts'])) {
            $_SESSION['posts'] = [];
        }
    }

    // Método para deletar um post
    public function deletePost($postIndex) {
        if (isset($_SESSION['posts'][$postIndex])) {
            unset($_SESSION['posts'][$postIndex]);

            // Reindexa o array de posts para manter os índices organizados
            $_SESSION['posts'] = array_values($_SESSION['posts']);
        } else {
            throw new Exception("Post não encontrado.");
        }
    }

    // Método para editar um post
    public function editPost($postIndex, $title, $content, $images = []) {
        if (isset($_SESSION['posts'][$postIndex])) {
            $_SESSION['posts'][$postIndex]->title = $title;
            $_SESSION['posts'][$postIndex]->content = $content;

            // Atualiza as imagens se novas imagens forem enviadas
            if (!empty($images)) {
                $_SESSION['posts'][$postIndex]->images = $images;
            }
        } else {
            throw new Exception("Post não encontrado.");
        }
    }

    // Método para criar um novo post
    public function createPost($title, $content, $images = []) {
        // Cria um novo post com os dados fornecidos
        $newPost = new Post($title, $content, $images);
        $_SESSION['posts'][] = $newPost;  // Armazena o post na sessão
    }

    // Método para adicionar uma avaliação a um post
    public function addRating($postIndex, $rating) {
        if (isset($_SESSION['posts'][$postIndex])) {
            $_SESSION['posts'][$postIndex]->addRating($rating);
        } else {
            throw new Exception("Post não encontrado.");
        }
    }

    // Método para redirecionar a página
    public function redirect($url) {
        header("Location: $url");
        exit;
    }

    // Método para salvar imagens enviadas e retornar o array de nomes de arquivo
    public function handleImages($files) {
        $imageNames = [];
        $imageDir = '../assets/images/';

        if (!empty($files['name'][0])) {
            foreach ($files['tmp_name'] as $key => $tmp_name) {
                $imageName = basename($files['name'][$key]);
                $targetFile = $imageDir . $imageName;

                // Move o arquivo para o diretório de imagens
                if (move_uploaded_file($tmp_name, $targetFile)) {
                    $imageNames[] = $imageName;
                }
            }
        }

        return $imageNames;
    }
}
