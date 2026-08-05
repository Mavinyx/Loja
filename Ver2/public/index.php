<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Core\Connection;
use App\Models\Usuario;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Endereco;
use App\Models\Categoria;

try {
    $pdo = Connection::getInstance();
    echo "Conectado!!";
} catch (Exception $e) {
    echo "Falha na fundação: " . $e->getMessage();
}
/*
try {
    
    $novoUsuario = new Usuario();
    $novoUsuario->nome_user = "teste";
    $novoUsuario->email = "teste@gmail.com";
    $novoUsuario->save();

    echo "Sucesso! Registro salvo com o ID: " . $novoUsuario->id_user . "<br>";

    $usuarioSalvo = Usuario::find($novoUsuario->id_user);
    echo "Nome resgatado do banco: " . $usuarioSalvo->nome_user;

} catch (Exception $e) {
    echo "Erro na operação: " . $e->getMessage();
}
    */
if(isset($_GET['table'])){
    $table = ucfirst($_GET['table']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="get">
        <select value="table" name="table">
            <?php
             foreach($pdo->query("SELECT table_name FROM information_schema.tables WHERE table_schema = 'lojafix'") as $row){
                echo "<option value='" . $row['table_name'] . "'>" . $row['table_name'] . "</option>";
            }
                ?>
        </select>
        <button type="submit">Submit</button>
    </form>
</body>
</html>
