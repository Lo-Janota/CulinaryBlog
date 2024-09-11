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

    <?php foreach ($_SESSION['posts'] as $index => $post): ?>
        <div class="post">
            <h2><?= $post->title ?></h2>
            <img src="assets/images/<?= $post->image ?>" alt="<?= $post->title ?>" />
            <p><?= $post->content ?></p>
            <p>Avaliação média: <?= $post->getAverageRating() ?></p>

            <h3>Comentários</h3>
            <?php foreach ($post->comments as $comment): ?>
                <p><strong><?= $comment->user ?>:</strong> <?= $comment->text ?></p>
            <?php endforeach; ?>

            <form action="comment_handler.php" method="post">
                <input type="hidden" name="post_index" value="<?= $index ?>">
                <input type="text" name="user" placeholder="Seu nome">
                <textarea name="comment" placeholder="Seu comentário"></textarea>
                <button type="submit">Comentar</button>
            </form>
        </div>
    <?php endforeach; ?>

    <?php include 'partials/footer.php'; ?>
</body>
</html>
