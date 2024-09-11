<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Postar Receita</title>
</head>

<body>
    <h1>Postar Nova Receita</h1>

    <form action="../post_handler.php" method="post" enctype="multipart/form-data">
        <label for="title">Título</label>
        <input type="text" name="title" required>

        <label for="content">Conteúdo</label>
        <textarea name="content" required></textarea>

        <label for="image">Imagem</label>
        <input type="file" name="image" required>

        <button type="submit">Publicar Receita</button>
    </form>
</body>
</html>