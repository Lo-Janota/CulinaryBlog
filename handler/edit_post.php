<?php

require_once '../classes/PostHandler.php';

$postHandler = new PostHandler();

if (!isset($_GET['post_id'])) {
    $postHandler->redirect('../index.php');
}

$postId = (int)$_GET['post_id'];

// Consulta para obter os dados do post
global $conn;
$sql = "SELECT title, content FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $postId);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    die("Post não encontrado.");
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Lida com o upload de imagens (se houver)
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

    // Atualiza o post
    try {
        $postHandler->editPost($postId, $title, $content, $images);
        $postHandler->redirect('../index.php');  // Redireciona para a página principal após editar
    } catch (Exception $e) {
        echo 'Erro: ' . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Post</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>
<body>
    <h1>Editar Post</h1>

    <form action="edit_post.php?post_id=<?= $postId ?>" method="post" enctype="multipart/form-data">
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($post['title']) ?>" required>

        <label for="content">Conteúdo:</label>
        <textarea name="content" id="content" required><?= htmlspecialchars($post['content']) ?></textarea>

        <label for="images">Imagens (opcional, se quiser substituir):</label>
        <input type="file" name="images[]" id="images" multiple>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
