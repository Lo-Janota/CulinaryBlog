<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <title>Postar Receita</title>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php include '../partials/header.php'; ?>

    <div class="post-container">
        <h1>Postar Nova Receita</h1>

        <form action="../post_handler.php" method="post" enctype="multipart/form-data">
            <label for="title">Título</label>
            <input type="text" name="title" id="title" required>

            <label for="content">Conteúdo</label>
            <textarea name="content" id="content" required></textarea>

            <label for="images">Imagens (selecione várias)</label>
            <input type="file" name="images[]" id="images" multiple required>

            <button type="submit">Publicar Receita</button>
        </form>

    </div>
</body>

</html>