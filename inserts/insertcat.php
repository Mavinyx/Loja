<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Categoria</title>
</head>
<body>
    <form action="inserts.php" method="post">
        <input type="hidden" name="formulario" value="categoria">
        <label for="nome_cat">Nome Categoria: <input type="text" name="nome_cat"></label>
        <label for="descricao">Descrição: <input type="text" name="descricao"></label>
        <button type='submit'>Criar Categoria</button>
    </form>
</body>
</html>