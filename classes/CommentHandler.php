<?php

require_once '../db_connection.php'; // Inclui a conexão com o banco de dados
require_once 'Comment.php';

class CommentHandler
{
    private $conn;

    public function __construct() {
        global $conn;
        $this->conn = $conn; // Inicializa a conexão com o banco de dados
    }

    // Método para processar o comentário
    public function processComment($postId, $user, $commentText) {
        // Insere o comentário no banco de dados
        $stmt = $this->conn->prepare("INSERT INTO comments (post_id, user, text) VALUES (?, ?, ?)");
        if (!$stmt) {
            throw new Exception("Erro ao preparar a query: " . $this->conn->error);
        }

        $stmt->bind_param("iss", $postId, $user, $commentText);

        if (!$stmt->execute()) {
            throw new Exception("Erro ao inserir o comentário: " . $stmt->error);
        }

        $stmt->close();

        // Redireciona para a página principal
        $this->redirect('../index.php');
    }

    // Método para redirecionar a página
    private function redirect($url) {
        header("Location: $url");
        exit;
    }

    // Método para carregar comentários de um post do banco de dados
    public function loadComments($postId) {
        $stmt = $this->conn->prepare("SELECT user, text FROM comments WHERE post_id = ?");
        if (!$stmt) {
            throw new Exception("Erro ao preparar a query: " . $this->conn->error);
        }

        $stmt->bind_param("i", $postId);
        $stmt->execute();
        $result = $stmt->get_result();

        $comments = [];
        while ($row = $result->fetch_assoc()) {
            $comments[] = new Comment($row['user'], $row['text']);
        }

        $stmt->close();
        return $comments;
    }
}
