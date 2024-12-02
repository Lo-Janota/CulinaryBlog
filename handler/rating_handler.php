<?php
require_once '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rating'], $_POST['post_id'])) {
    $rating = (int)$_POST['rating'];
    $postId = (int)$_POST['post_id'];

    try {
        // Inserir ou atualizar a avaliação
        $sql = "INSERT INTO ratings (post_id, rating) VALUES (?, ?) 
                ON DUPLICATE KEY UPDATE rating = VALUES(rating)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ii", $postId, $rating);
        $stmt->execute();
        $stmt->close();

        header("Location: ../index.php");
        exit();
    } catch (Exception $e) {
        echo "Erro ao salvar a avaliação: " . $e->getMessage();
    }
}
?>
