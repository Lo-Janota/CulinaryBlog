<?php

require_once 'Post.php';
require_once 'Comment.php';
require_once '../db_connection.php';

class PostHandler {
    public function getPostsFromDatabase() {
        global $conn;

        $sqlPosts = "
            SELECT posts.id, posts.title, posts.content, 
                   GROUP_CONCAT(images.image_path) AS images,
                   COALESCE(AVG(ratings.rating), 0) AS average_rating
            FROM posts
            LEFT JOIN images ON posts.id = images.post_id
            LEFT JOIN ratings ON posts.id = ratings.post_id
            GROUP BY posts.id
            ORDER BY posts.created_at DESC";
        $resultPosts = $conn->query($sqlPosts);

        $posts = [];
        if ($resultPosts && $resultPosts->num_rows > 0) {
            while ($row = $resultPosts->fetch_assoc()) {
                $images = $row['images'] ? explode(',', $row['images']) : [];
                $post = new Post($row['title'], $row['content'], $images, $row['id']);
                $post->averageRating = round($row['average_rating'], 1);
                $posts[] = $post;
            }
        }
        return $posts;
    }

    public function editPost($postId, $title, $content, $images = []) {
        global $conn;

        // Atualizar título e conteúdo do post
        $sqlUpdatePost = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
        $stmtPost = $conn->prepare($sqlUpdatePost);
        $stmtPost->bind_param("ssi", $title, $content, $postId);
        $stmtPost->execute();

        // Substituir imagens, se fornecidas
        if (!empty($images)) {
            // Deletar imagens existentes
            $sqlDeleteImages = "DELETE FROM images WHERE post_id = ?";
            $stmtDeleteImages = $conn->prepare($sqlDeleteImages);
            $stmtDeleteImages->bind_param("i", $postId);
            $stmtDeleteImages->execute();

            // Inserir novas imagens
            foreach ($images as $imagePath) {
                $sqlInsertImage = "INSERT INTO images (post_id, image_path) VALUES (?, ?)";
                $stmtInsertImage = $conn->prepare($sqlInsertImage);
                $stmtInsertImage->bind_param("is", $postId, $imagePath);
                $stmtInsertImage->execute();
            }
        }
    }

    public function redirect($url) {
        header("Location: $url");
        exit();
    }
}
?>
