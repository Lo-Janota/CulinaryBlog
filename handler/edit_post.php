<?php

require_once '../classes/PostHandler.php';

$postHandler = new PostHandler();

if (!isset($_GET['post_index'])) {
    $postHandler->redirect('index.php');
}

$postIndex = $_GET['post_index'];
$post = $_SESSION['posts'][$postIndex];

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    // Lida com o upload de imagens (se houver)
    $images = $postHandler->handleImages($_FILES['images']);

    // Atualiza o post
    try {
        $postHandler->editPost($postIndex, $title, $content, $images);
        $postHandler->redirect('../index.php');  // Redireciona para a página principal após editar
    } catch (Exception $e) {
        // Em caso de erro, exibe a mensagem de erro
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
