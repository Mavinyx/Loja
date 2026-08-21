<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';

use App\Models\Usuario;
use App\Models\Endereco;

$usuarioEdicao = null;
$enderecoEdicao = null;


if (isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    Endereco::deleteByUsuario($id);

    $usuario = Usuario::find($id);
    if ($usuario){
        try{
            $usuario->delete();
        }catch(PDOException $e){}
    } 
    
    header('Location: painel.php');
    exit;
}


if ($_POST) {
    $id_user = $_POST['id_user'] ?? null;
    $id_end = $_POST['id_end'] ?? null;

    $usuario = new Usuario();
    if ($id_user) $usuario->id_user = $id_user;
    $usuario->nome_user = $_POST['nome_user'];
    $usuario->email = $_POST['email'];
    $usuario->save();

    $endereco = new Endereco();
    if ($id_end) $endereco->id_end = $id_end;
    $endereco->id_user = $usuario->id_user;
    $endereco->cep = $_POST['cep'];
    $endereco->numero = $_POST['numero'];
    $endereco->cidade = $_POST['cidade'];
    $endereco->estado = $_POST['estado'];
    $endereco->save();

    header('Location: painel.php');
    exit;
}


if (isset($_GET['editar'])) {
    $usuarioEdicao = Usuario::find((int) $_GET['editar']);
    if ($usuarioEdicao) {
        $enderecoEdicao = Endereco::findByUsuario($usuarioEdicao->id_user);
    }
}

$listaUsuarios = Usuario::all();

?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel de Usuários</title>
</head>
<body>
    <h2>Gerenciamento de Usuários</h2>

    <div>
        <h3><?= $usuarioEdicao ? 'Editar' : 'Novo' ?></h3>
       
        <form action="" method="POST">
            <input type="hidden" name="id_user" value="<?= $usuarioEdicao ? $usuarioEdicao->id_user : '' ?>">
            <input type="hidden" name="id_end" value="<?= $enderecoEdicao ? $enderecoEdicao->id_end : '' ?>">
            
            <input type="text" name="nome_user" value="<?= $usuarioEdicao ? $usuarioEdicao->nome_user : '' ?>" required>
            <input type="email" name="email" value="<?= $usuarioEdicao ? $usuarioEdicao->email : '' ?>" required>
            <input type="text" name="cep" value="<?= $enderecoEdicao ? $enderecoEdicao->cep : '' ?>" required>
            <input type="number" name="numero" value="<?= $enderecoEdicao ? $enderecoEdicao->numero : '' ?>" required>
            <input type="text" name="cidade" value="<?= $enderecoEdicao ? $enderecoEdicao->cidade : '' ?>" required>
            <input type="text" name="estado" value="<?= $enderecoEdicao ? $enderecoEdicao->estado : '' ?>" required>
            
            <button type="submit">Salvar</button>
            <?php if ($usuarioEdicao): ?> <a href="painel.php">Cancelar</a> <?php endif; ?>
        </form>
    </div>


    <table border="1">
        <tr><th>ID</th><th>Nome</th><th>Ações</th></tr>
        <?php foreach ($listaUsuarios as $user): ?>
            <tr>
                <td><?= $user['id_user'] ?></td>
                <td><?= $user['nome_user'] ?></td>
                <td>
                    <a href="?editar=<?= $user['id_user'] ?>">Editar</a> | 
                    <a href="?deletar=<?= $user['id_user'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
