<?php

require_once '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $user = $_POST['user'];
    $commentText = $_POST['comment'];

    if (!empty($postId) && !empty($user) && !empty($commentText)) {
        try {
            $stmt = $conn->prepare("INSERT INTO comments (post_id, user, text) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $postId, $user, $commentText);
            $stmt->execute();
            $stmt->close();
            $conn->close();
            header('Location: ../index.php');
            exit;
        } catch (Exception $e) {
            echo "Erro ao salvar o comentário: " . $e->getMessage();
        }
    } else {
        echo "Todos os campos são obrigatórios!";
    }
}
?>
