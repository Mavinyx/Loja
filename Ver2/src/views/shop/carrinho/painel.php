<?php

require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Models\Usuario;
use App\Models\Venda;
//equivale a tabela venda
$vendaEdicao = null;
if(isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    $venda = Venda::find($id);
    if ($venda){
        try{
            $venda->delete();
        }catch(PDOException $e){}
    }
    header('Location: painel.php');
    exit;
}
if($_POST){
    $id_venda = $_POST['id_venda'] ?? null;
    $venda = new Venda();
    if ($id_venda) {
        $venda->id_venda = $id_venda;
    }
    $venda->id_user = $_POST['id_user'];
    $venda->data_ped = $_POST['data_ped'];
    $venda->save();
    header('Location: painel.php');
    exit;
}
if(isset($_GET['editar'])) {
    $id = (int) $_GET['editar'];
    $vendaEdicao = Venda::find($id);
}
$listaUsuarios = Usuario::all();
$listaVendas = Venda::all();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho</title>
</head>
<body>
    <h2>Carrinho</h2>
    <div>
    <form action='' method='post'>
        <input type='hidden' name='id_venda' id='id_venda' value="<?= $vendaEdicao ? $vendaEdicao->id_venda : ''?>">
        <label for="id_user">Usuario:</label>
        <select name="id_user" id="id_user">
            <?php  foreach($listaUsuarios as $usuario): ?>
                <option value="<?= $usuario['id_user'] ?>" <?= $vendaEdicao && $vendaEdicao->id_user == $usuario['id_user'] ? 'selected' : '' ?>>
                    <?= $usuario['nome_user'] ?>
                </option>
            <?php endforeach;?>
        </select>
        <label for="data_ped">Data do Pedido:</label>
        <input type="date" name='data_ped' id='data_ped' value='<?= $vendaEdicao ? $vendaEdicao->data_ped : '' ?>'>
        <button type='submit'><?= $vendaEdicao ? 'Atualizar' : 'Adicionar' ?></button>
    </form> 
    </div>
    <table border='1'>
            <tr><th>ID</th><th>Comprador</th><th>Valor</th><th>Data</th><th>Ações</th></tr>
            <?php foreach($listaVendas as $venda):?>
            <tr>
                <td><?= $venda['id_venda'] ?></td>
                <td><?= $venda['id_user'] ?></td>
                <td><?= $venda['valor_tot'] ?></td>
                <td><?= $venda['data_ped'] ?></td>
                <td>
                    <a href="?editar=<?= $venda['id_venda']?>">Editar</a> | 
                    <a href="?deletar=<?= $venda['id_venda']?>">Deletar</a> | 
                    <a href="detalhes.php?id_venda=<?= $venda['id_venda']?>">Detalhes</a>
                </td>
            </tr>
            <?php endforeach;?>
    </table>
</body>
</html>