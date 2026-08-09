<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Models\Fornecedor;

$fornecedorEdicao = null;
if (isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    $fornecedor = Fornecedor::find($id);
    if ($fornecedor) {
        $fornecedor->delete();
    }
    header('Location: painel.php');
    exit;
}
if($_POST) {
    $id_fornecedor = $_POST['id_forn'] ?? null;
    $fornecedor = new Fornecedor();
    if ($id_fornecedor) {
        $fornecedor->id_forn = $id_fornecedor;
    }
    $fornecedor->nome_forn = $_POST['nome_forn'];
    $fornecedor->email = $_POST['email'];
    $fornecedor->endereco = $_POST['endereco'];
    $fornecedor->save();
    header('Location: painel.php');
    exit;
}
if (isset($_GET['editar'])) {
    $fornecedorEdicao = Fornecedor::find((int) $_GET['editar']);
}
$listaFornecedores = Fornecedor::all();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Fornecedores</title>
</head>
<body>
   
        <h2>Gerenciamento de Fornecedores</h2>
    </div>
    <form action="" method="POST">
        <input type="hidden" name="id_forn" value="<?= $fornecedorEdicao ? $fornecedorEdicao->id_forn : '' ?>">
        <label for="nome_forn">Nome do Fornecedor:</label>
        <input type="text" id="nome_forn" name="nome_forn" value="<?= $fornecedorEdicao ? $fornecedorEdicao->nome_forn : '' ?>" required>
        <label for="email_forn">Email do Fornecedor:</label>
        <input type="email" id="email" name="email" value="<?= $fornecedorEdicao ? $fornecedorEdicao->email : '' ?>" required>
        <label for="endereco_forn">Endereço do Fornecedor:</label>
        <input type="text" id="endereco" name="endereco" value="<?= $fornecedorEdicao ? $fornecedorEdicao->endereco : '' ?>" required>

        <button type="submit"><?= $fornecedorEdicao ? 'Atualizar' : 'Adicionar' ?></button>
    </form>
    </div>
    <table border="1">
        <tr><th>ID</th><th>Nome</th><th>Email</th><th>Endereço</th><th>Ações</th></tr>
        <?php foreach ($listaFornecedores as $fornecedor): ?>
            <tr>
                <td><?= $fornecedor['id_forn'] ?></td>
                <td><?= $fornecedor['nome_forn'] ?></td>
                <td><?= $fornecedor['email'] ?></td>
                <td><?= $fornecedor['endereco'] ?></td>
                <td>
                    <a href="?editar=<?= $fornecedor['id_forn'] ?>">Editar</a> | 
                    <a href="?deletar=<?= $fornecedor['id_forn'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>