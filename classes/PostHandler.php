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
}
?>
