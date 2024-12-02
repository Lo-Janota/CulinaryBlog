<?php
require_once '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $postId = (int)$_POST['post_id'];

    try {
        // Iniciar uma transação para garantir consistência
        $conn->begin_transaction();

        // Deletar as imagens associadas ao post
        $sqlDeleteImages = "DELETE FROM images WHERE post_id = ?";
        $stmtImages = $conn->prepare($sqlDeleteImages);
        $stmtImages->bind_param("i", $postId);
        $stmtImages->execute();

        // Deletar os comentários associados ao post
        $sqlDeleteComments = "DELETE FROM comments WHERE post_id = ?";
        $stmtComments = $conn->prepare($sqlDeleteComments);
        $stmtComments->bind_param("i", $postId);
        $stmtComments->execute();

        // Deletar as avaliações associadas ao post
        $sqlDeleteRatings = "DELETE FROM ratings WHERE post_id = ?";
        $stmtRatings = $conn->prepare($sqlDeleteRatings);
        $stmtRatings->bind_param("i", $postId);
        $stmtRatings->execute();

        // Deletar o post
        $sqlDeletePost = "DELETE FROM posts WHERE id = ?";
        $stmtPost = $conn->prepare($sqlDeletePost);
        $stmtPost->bind_param("i", $postId);
        $stmtPost->execute();

        // Finalizar a transação
        $conn->commit();

        header("Location: ../index.php");
        exit();
    } catch (Exception $e) {
        $conn->rollback(); // Reverter alterações em caso de erro
        echo "Erro ao excluir o post: " . $e->getMessage();
    }
}
?>
