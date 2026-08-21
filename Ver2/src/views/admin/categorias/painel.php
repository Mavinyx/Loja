<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Models\Categoria;

$categoriaEdicao = null;
if (isset($_GET['deletar'])) {
    $id = (int) $_GET['deletar'];
    $categoria = Categoria::find($id);
    if ($categoria) {
        try{
            $categoria->delete();
        }catch(PDOException $e){}
    }
    header('Location: painel.php');
    exit;
}
if($_POST) {
    $id_categoria = $_POST['id_cat'] ?? null;
    $categoria = new Categoria();
    if ($id_categoria) {
        $categoria->id_cat = $id_categoria;
    }
    $categoria->nome_cat = $_POST['nome_cat'];
    $categoria->descricao= $_POST['descricao'];
    $categoria->save();
    header('Location: painel.php');
    exit;
}
if (isset($_GET['editar'])) {
    $categoriaEdicao = Categoria::find((int) $_GET['editar']);
}
$listaCategorias = Categoria::all();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Categorias</title>
</head>
<body>
   
        <h2>Gerenciamento de Categorias</h2>
    </div>
    <form action="" method="POST">
        <input type="hidden" name="id_cat" value="<?= $categoriaEdicao ? $categoriaEdicao->id_cat : '' ?>">
        <label for="nome_cat">Nome da Categoria:</label>
        <input type="text" id="nome_cat" name="nome_cat" value="<?= $categoriaEdicao ? $categoriaEdicao->nome_cat : '' ?>" required>
        <label for="descr_cat">Descrição:</label>
        <input type="text" id="descricao" name="descricao" value="<?= $categoriaEdicao ? $categoriaEdicao->descr_cat : '' ?>" required>
        <button type="submit"><?= $categoriaEdicao ? 'Atualizar' : 'Adicionar' ?></button>
    </form>
    </div>
    <table border="1">
        <tr><th>ID</th><th>Nome</th><th>Descrição</th><th>Ações</th></tr>
        <?php foreach ($listaCategorias as $categoria): ?>
            <tr>
                <td><?= $categoria['id_cat'] ?></td>
                <td><?= $categoria['nome_cat'] ?></td>
                <td><?= $categoria['descricao'] ?></td>
                <td>
                    <a href="?editar=<?= $categoria['id_cat'] ?>">Editar</a> | 
                    <a href="?deletar=<?= $categoria['id_cat'] ?>">Excluir</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>