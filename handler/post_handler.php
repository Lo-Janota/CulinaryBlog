<?php

require_once '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $images = [];

    if (!empty($_FILES['images']['name'][0])) {
        foreach ($_FILES['images']['tmp_name'] as $key => $tmpName) {
            $imageName = basename($_FILES['images']['name'][$key]);
            $targetFile = '../assets/images/' . $imageName;
            if (move_uploaded_file($tmpName, $targetFile)) {
                $images[] = $imageName;
            }
        }
    }

    try {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        $stmt->execute();
        $postId = $stmt->insert_id;

        if (!empty($images)) {
            foreach ($images as $imagePath) {
                $stmt = $conn->prepare("INSERT INTO images (post_id, image_path) VALUES (?, ?)");
                $stmt->bind_param("is", $postId, $imagePath);
                $stmt->execute();
            }
        }

        $stmt->close();
        $conn->close();
        header('Location: ../index.php');
    } catch (Exception $e) {
        echo "Erro ao salvar a receita: " . $e->getMessage();
    }
}
?>
