<?php
// Inclua as definições das classes
require_once 'classes/Post.php';
require_once 'classes/Comment.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];  // Obtém o índice do post correto
    $user = $_POST['user'];
    $commentText = $_POST['comment'];

    // Cria um novo comentário
    $newComment = new Comment($user, $commentText);

    // Adiciona o comentário ao post correto
    $_SESSION['posts'][$postIndex]->addComment($newComment);

    // Redireciona para a página principal
    header('Location: index.php');
    exit;
}
?>
