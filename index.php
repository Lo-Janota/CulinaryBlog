<?php
// Inclua as definições das classes
require_once 'classes/Post.php';
require_once 'classes/Comment.php';

// Iniciar a sessão
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Carregar a página inicial do blog
include 'views/home.php';
?>
