<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Fornecedor;
$produtoEdicao = null;

if(isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    $produto = Produto::find($id);
    if ($produto) {
        $produto->delete();
    }
    header('Location: painel.php');
    exit;
}
if($_POST){
    $id_prod = $_POST['id_prod'] ?? null;
    $produto = new Produto();
    if ($id_prod) {
        $produto->id_prod = $id_prod;
    }
    $produto->nome_prod = $_POST['nome_prod'];
    $produto->preco = $_POST['preco'];
    $produto->id_cat = $_POST['id_cat'];
    $produto->id_forn = $_POST['id_forn'];
    $produto->descricao = $_POST['descricao'];
    $produto->estoque = $_POST['estoque'];
    $produto->save();
    header('Location: painel.php');
    exit;
}
if(isset($_GET['editar'])) {
    $id = (int) $_GET['editar'];
    $produtoEdicao = Produto::find($id);
}
$listaProdutos = Produto::all();
$listaCategorias = Categoria::all();
$listaFornecedores = Fornecedor::all();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Produtos</title>
</head>
<body>
    <h2>Gerenciamento de Produtos</h2>
    <div>
        <form action="" method="POST">
            <input type="hidden" name="id_prod" value="<?= $produtoEdicao ? $produtoEdicao->id_prod : '' ?>">
            <label for="nome_prod">Nome do Produto:</label>
            <input type="text" id="nome_prod" name="nome_prod" value="<?= $produtoEdicao ? $produtoEdicao->nome_prod : '' ?>" required>
            <label for="preco">Preço:</label>
            <input type="number" step="0.01" min="0" id="preco" name="preco" value="<?= $produtoEdicao ? $produtoEdicao->preco : '' ?>" required>
            <label for="id_cat">Categoria:</label>
            <select id="id_cat" name="id_cat" required>
                <?php foreach ($listaCategorias as $categoria): ?>
                    <option value="<?= $categoria['id_cat'] ?>" <?= $produtoEdicao && $produtoEdicao->id_cat == $categoria['id_cat'] ? 'selected' : '' ?>>
                        <?= $categoria['nome_cat'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="id_forn">Fornecedor:</label>
            <select id="id_forn" name="id_forn" required>
                <?php foreach ($listaFornecedores as $fornecedor): ?>
                    <option value="<?= $fornecedor['id_forn'] ?>" <?= $produtoEdicao && $produtoEdicao->id_forn == $fornecedor['id_forn'] ? 'selected' : '' ?>>
                        <?= $fornecedor['nome_forn'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label for="descricao">Descrição:</label>
            <textarea id="descricao" name="descricao" required><?= $produtoEdicao ? $produtoEdicao->descricao : '' ?></textarea>
            <label for="estoque">Estoque:</label>
            <input type="number" min="0" id="estoque" name="estoque" value="<?= $produtoEdicao ? $produtoEdicao->estoque : '' ?>" required>
            <button type="submit"><?= $produtoEdicao ? 'Atualizar' : 'Adicionar' ?></button>
        </form>
    </div>
    <table border=1>
        <tr><th>ID</th><th>Nome</th><th>Preço</th><th>Categoria</th><th>Fornecedor</th><th>Estoque</th><th>Ações</th></tr>
        <?php foreach ($listaProdutos as $produto): ?>
            <tr>
                <td><?= $produto['id_prod'] ?></td>
                <td><?= $produto['nome_prod'] ?></td>
                <td><?= $produto['preco'] ?></td>
                <td><?= $produto['id_cat'] ?></td>
                <td><?= $produto['id_forn'] ?></td>
                <td><?= $produto['estoque'] ?></td>
                <td>
                    <a href="?editar=<?= $produto['id_prod'] ?>">Editar</a> | 
                    <a href="?deletar=<?= $produto['id_prod'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>