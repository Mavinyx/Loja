<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Usuario</title>
</head>
<body>
    <form action="inserts.php" method="post">
        <input type="hidden" name="formulario" value="usuario">
        <label for="nome">Nome: <input type="text" name="nome_user"></label>
        <label for="email">Email: <input type="text" name="email"></label>
        <button type='submit'>Criar Usuario</button>
    </form>
</body>
</html>