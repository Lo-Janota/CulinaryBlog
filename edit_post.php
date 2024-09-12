<?php
require_once 'classes/Post.php';
session_start();

if (!isset($_GET['post_index'])) {
    header('Location: index.php');
    exit;
}

$postIndex = $_GET['post_index'];
$post = $_SESSION['posts'][$postIndex];

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Atualiza o post na sessão
    $_SESSION['posts'][$postIndex]->title = $title;
    $_SESSION['posts'][$postIndex]->content = $content;

    // Lida com imagens, se forem alteradas
    if (!empty($_FILES['images']['name'][0])) {
        $imageNames = [];
        $imageDir = 'assets/images/';

        foreach ($_FILES['images']['tmp_name'] as $key => $tmp_name) {
            $imageName = basename($_FILES['images']['name'][$key]);
            $targetFile = $imageDir . $imageName;

            if (move_uploaded_file($tmp_name, $targetFile)) {
                $imageNames[] = $imageName;
            }
        }

        $_SESSION['posts'][$postIndex]->images = $imageNames;
    }

    // Redireciona de volta para a página inicial
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Post</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Editar Post</h1>

    <form action="edit_post.php?post_index=<?= $postIndex ?>" method="post" enctype="multipart/form-data">
        <label for="title">Título:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($post->title) ?>" required>

        <label for="content">Conteúdo:</label>
        <textarea name="content" id="content" required><?= htmlspecialchars($post->content) ?></textarea>

        <label for="images">Imagens (opcional, se quiser substituir):</label>
        <input type="file" name="images[]" id="images" multiple>

        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>
