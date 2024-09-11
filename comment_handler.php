<?php
require_once 'classes/Post.php';
require_once 'classes/Comment.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postIndex = $_POST['post_index'];
    $user = $_POST['user'];
    $commentText = $_POST['comment'];

    $newComment = new Comment($user, $commentText);

    // Adicionar o comentário ao post
    $_SESSION['posts'][$postIndex]->addComment($newComment);

    header('Location: index.php');
    exit;
}
?>
