<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
</head>
<body>
    <form action="inserts.php" method="post">
        <input type="hidden" name="formulario" value="fornecedor">
        <label for="nome_forn">Nome Fornecedor: <input type="text" name="nome_forn"></label>
        <button type='submit'>Cadastrar Fornecedor</button>
    </form>
</body>
</html>