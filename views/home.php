<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['posts'])) {
    $_SESSION['posts'] = [];
}
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Blog de Receitas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <h1>Receitas Recentes</h1>

    <div class="posts-container">

    <?php
    // Inverte a ordem dos posts para mostrar o mais recente primeiro
    $postsReversed = array_reverse($_SESSION['posts']);
    
    foreach ($postsReversed as $index => $post): ?>
        <div class="post">
            <h2><?= htmlspecialchars($post->title) ?></h2>
            <img src="assets/images/<?= htmlspecialchars($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" />
            <p><?= nl2br(htmlspecialchars($post->content)) ?></p>
            <p>Avaliação média: <?= htmlspecialchars($post->getAverageRating()) ?></p>

            <h3>Comentários</h3>
            <?php foreach ($post->comments as $comment): ?>
                <p><strong><?= htmlspecialchars($comment->user) ?>:</strong> <?= htmlspecialchars($comment->text) ?></p>
            <?php endforeach; ?>

            <form action="comment_handler.php" method="post">
                <input type="hidden" name="post_index" value="<?= htmlspecialchars($index) ?>">
                <input type="text" name="user" placeholder="Seu nome" required>
                <textarea name="comment" placeholder="Seu comentário" required></textarea>
                <button type="submit">Comentar</button>
            </form>
        </div>
    <?php endforeach; ?>
    
    <?php include 'partials/footer.php'; ?>
</body>
</html>
