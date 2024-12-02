<?php
// Inclua a conexão com o banco de dados
require_once 'db_connection.php';
require_once 'classes/Post.php';
require_once 'classes/Comment.php';

try {
    // Consulta para obter posts e imagens do banco de dados, junto com a média de avaliação
    $sqlPosts = "
        SELECT posts.id, posts.title, posts.content, GROUP_CONCAT(images.image_path) AS images, 
        (SELECT AVG(rating) FROM ratings WHERE post_id = posts.id) AS average_rating
        FROM posts
        LEFT JOIN images ON posts.id = images.post_id
        GROUP BY posts.id
        ORDER BY posts.created_at DESC";
    $resultPosts = $conn->query($sqlPosts);

    $posts = [];
    if ($resultPosts && $resultPosts->num_rows > 0) {
        while ($row = $resultPosts->fetch_assoc()) {
            $images = $row['images'] ? explode(',', $row['images']) : [];
            $post = new Post($row['title'], $row['content'], $images);
            $post->id = $row['id'];

            // A média de avaliação é calculada diretamente da consulta SQL
            $post->averageRating = round($row['average_rating'] ?? 0, 1);  // Arredondar a média para 1 casa decimal

            // Consulta para obter comentários do post
            $sqlComments = "SELECT user, text FROM comments WHERE post_id = ?";
            $stmtComments = $conn->prepare($sqlComments);
            $stmtComments->bind_param("i", $row['id']);
            $stmtComments->execute();
            $resultComments = $stmtComments->get_result();

            if ($resultComments && $resultComments->num_rows > 0) {
                while ($commentRow = $resultComments->fetch_assoc()) {
                    $comment = new Comment($commentRow['user'], $commentRow['text']);
                    $post->addComment($comment);
                }
            }
            $posts[] = $post;
        }
    }
} catch (Exception $e) {
    die("Erro ao carregar os posts: " . $e->getMessage());
}
?>

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
                    <div id="carousel-<?= $index ?>" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner">
                            <?php foreach ($post->images as $key => $image): ?>
                                <div class="carousel-item <?= $key === 0 ? 'active' : '' ?>">
                                    <img src="assets/images/<?= htmlspecialchars($image) ?>" class="d-block w-100" alt="Imagem <?= $key + 1 ?>">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <p><?= nl2br(htmlspecialchars($post->content)) ?></p>

                    <!-- Exibição das estrelas com a média de avaliações -->
                    <div class="rating">
                        <span>
                            <?php
                            // Calculando a exibição das estrelas com base na média
                            $averageRating = $post->averageRating;

                            for ($i = 1; $i <= 5; $i++) {
                                if ($i <= floor($averageRating)) {
                                    echo '★';  // Estrela cheia
                                } else {
                                    echo '☆';  // Estrela vazia
                                }
                            }
                            ?>
                        </span>
                        <small><?= number_format($averageRating, 1) ?> / 5</small>
                    </div>

                    <!-- Botão de deletar -->
                    <form action="handler/delete_post.php" method="post" style="display: inline;">
                        <input type="hidden" name="post_id" value="<?= $post->id ?>">
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja excluir este post?')">
                            <i class="bi bi-trash"></i> Deletar
                        </button>
                    </form>

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
