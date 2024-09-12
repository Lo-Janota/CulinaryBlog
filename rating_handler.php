<?php
// Inclua a definição da classe Post
require_once 'classes/Post.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];  // Obtém o índice do post correto
    $rating = (int) $_POST['rating'];

    // Adiciona a avaliação ao post correto
    $_SESSION['posts'][$postIndex]->addRating($rating);

    // Redireciona para a página principal
    header('Location: index.php');
    exit;
}
?>
