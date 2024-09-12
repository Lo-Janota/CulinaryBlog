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

<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap JS and dependencies -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

