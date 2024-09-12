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

    <div class="posts-container">
    <h1>Receitas Recentes</h1>

    <?php
    $postsReversed = array_reverse($_SESSION['posts'], true);

    foreach ($postsReversed as $index => $post): ?>
        <div class="post">
            <h2><?= htmlspecialchars($post->title) ?></h2>
            <img src="assets/images/<?= htmlspecialchars($post->image) ?>" alt="<?= htmlspecialchars($post->title) ?>" />
            <p><?= nl2br(htmlspecialchars($post->content)) ?></p>

            <!-- Avaliações no canto inferior direito -->
            <div class="rating">
                <span>
                <?php
                $averageRating = round($post->getAverageRating());
                for ($i = 1; $i <= 5; $i++) {
                    echo $i <= $averageRating ? '★' : '☆';
                }
                ?>
                </span>
                <small><?= number_format($post->getAverageRating(), 1) ?> / 5</small>
            </div>

            <!-- Formulário de avaliação -->
            <form action="rating_handler.php" method="post">
                <label for="rating">Avalie:</label>
                <select name="rating" id="rating" required>
                    <option value="1">1 Estrela</option>
                    <option value="2">2 Estrelas</option>
                    <option value="3">3 Estrelas</option>
                    <option value="4">4 Estrelas</option>
                    <option value="5">5 Estrelas</option>
                </select>
                <input type="hidden" name="post_index" value="<?= $index ?>">
                <button type="submit">Avaliar</button>
            </form>

            <!-- Seção de comentários -->
            <div class="comment-section">
                <h3>Comentários</h3>
                <?php foreach ($post->comments as $comment): ?>
                    <p><strong><?= htmlspecialchars($comment->user) ?>:</strong> <?= htmlspecialchars($comment->text) ?></p>
                <?php endforeach; ?>

                <form action="comment_handler.php" method="post">
                    <input type="hidden" name="post_index" value="<?= $index ?>">
                    <input type="text" name="user" placeholder="Seu nome" required>
                    <textarea name="comment" placeholder="Seu comentário" required></textarea>
                    <button type="submit">Comentar</button>
                </form>
            </div>
        </div>
    <?php endforeach; ?>
</div>



</body>

</html>