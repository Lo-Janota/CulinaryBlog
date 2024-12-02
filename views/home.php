<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Blog de Receitas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="assets/js/script.js"></script>
</head>
<body>
    <?php include 'partials/header.php'; ?>

    <div class="posts-container">
        <h1>Receitas Recentes</h1>

        <?php if (!empty($posts)): ?>
            <?php foreach ($posts as $index => $post): ?>
                <div class="post">
                    <h2><?= htmlspecialchars($post->title) ?></h2>

                    <!-- Botões de Editar, Deletar e Compartilhar -->
                    <span class="float-right">
                        <a href="handler/edit_post.php?post_id=<?= $post->id ?>" class="btn btn-sm btn-primary">
                            <i class="bi bi-pencil fs-4"></i>
                        </a>
                        <form action="handler/delete_post.php" method="post" style="display:inline;">
                            <input type="hidden" name="post_id" value="<?= $post->id ?>">
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-trash fs-4"></i>
                            </button>
                        </form>
                        <button class="btn btn-sm btn-success" onclick="copyToClipboard('<?= 'http://localhost:3000/?post_id=' . $post->id ?>')">
                            <i class="bi bi-share fs-4"></i>
                        </button>
                    </span>

                    <!-- Carrossel de imagens Bootstrap -->
                    <div id="carousel-<?= $index ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($post->images as $key => $image): ?>
                                <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                    <img src="assets/images/<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="Imagem <?= $key + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <a class="carousel-control-prev" href="#carousel-<?= $index ?>" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Anterior</span>
                        </a>
                        <a class="carousel-control-next" href="#carousel-<?= $index ?>" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Próximo</span>
                        </a>
                    </div>

                    <p><?= nl2br(htmlspecialchars($post->content)) ?></p>

                    <!-- Avaliações -->
                    <div class="rating">
                        <span>
                            <?php
                            $averageRating = $post->averageRating;

                            for ($i = 1; $i <= 5; $i++) {
                                echo $i <= $averageRating ? '★' : '☆';
                            }
                            ?>
                        </span>
                        <small><?= number_format($averageRating, 1) ?> / 5</small>
                    </div>

                    <!-- Formulário de avaliação -->
                    <form action="handler/rating_handler.php" method="post">
                        <label for="rating">Avalie:</label>
                        <select name="rating" id="rating" required>
                            <option value="1">1 Estrela</option>
                            <option value="2">2 Estrelas</option>
                            <option value="3">3 Estrelas</option>
                            <option value="4">4 Estrelas</option>
                            <option value="5">5 Estrelas</option>
                        </select>
                        <input type="hidden" name="post_id" value="<?= $post->id ?>">
                        <button type="submit">Avaliar</button>
                    </form>

                    <!-- Seção de comentários -->
                    <div class="comment-section">
                        <h3>Comentários</h3>
                        <?php foreach ($post->comments as $comment): ?>
                            <p><strong><?= htmlspecialchars($comment->user) ?>:</strong> <?= htmlspecialchars($comment->text) ?></p>
                        <?php endforeach; ?>
                        <form action="handler/comment_handler.php" method="post">
                            <input type="hidden" name="post_id" value="<?= $post->id ?>">
                            <input type="text" name="user" placeholder="Seu nome" required>
                            <textarea name="comment" placeholder="Seu comentário" required></textarea>
                            <button type="submit">Comentar</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhuma receita encontrada.</p>
        <?php endif; ?>
    </div>
</body>
</html>
