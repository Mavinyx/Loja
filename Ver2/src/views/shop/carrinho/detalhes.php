<?php
require_once __DIR__ . '/../../../../vendor/autoload.php'; 

use App\Models\Prod_Venda;
use App\Models\Produto;
use App\Models\Venda;


$idVenda = $_GET['id_venda'] ?? $_POST['id_venda'] ?? null;
$venda = $idVenda ? Venda::find((int) $idVenda) : null;

if (isset($_GET['deletar']) && $venda) {
    $idProdVenda = (int) $_GET['deletar'];
    $produtoVenda = Prod_Venda::find($idProdVenda);
    if ($produtoVenda) {
        $valorRemover = (float) $produtoVenda->valor_venda_prd;

        if ($produtoVenda->delete()) {
            $venda->atualizarTotal(-$valorRemover);
        }
    }
    header('Location: detalhes.php?id_venda=' . $idVenda);
    exit;
}


if ($_POST && isset($_POST['inserir'])) {
    $id_prod = (int) $_POST['id_prod'];
    $quant = (int) $_POST['quant'];

    $produto = Produto::find($id_prod);

    if ($produto && $venda && $quant > 0) {
        $valor_venda_prd = (float) $produto->preco * $quant;

        $novoProdVenda = new Prod_Venda();
        $novoProdVenda->id_venda = $venda->id_venda; 
        $novoProdVenda->id_prod = $id_prod;
        $novoProdVenda->quant = $quant;
        $novoProdVenda->valor_venda_prd = $valor_venda_prd;

        if ($novoProdVenda->save()) {
            $venda->atualizarTotal($valor_venda_prd);
        }

        header('Location: detalhes.php?id_venda=' . $idVenda);
        exit;
    }
    

    die("Erro: Produto não encontrado ou quantidade inválida.");
}


$listaProdutos_Venda = $idVenda ? Prod_Venda::all($idVenda) : [];
$listaProdutos = Produto::all();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicione produtos ao carrinho</title>
</head>
<body>
    <a href="painel.php">Voltar</a>
    <h3>Seus itens no carrinho</h3>
    <?php if (!$idVenda): ?>
        <p>Venda nao informada.</p>
    <?php else: ?>
        <p>Total da venda: R$ <?= number_format((float) $venda->valor_tot, 2, ',', '.') ?></p>
    <?php endif; ?>

    <div>
        <table border="1">
            <tr><th>Produto</th><th>Quantidade</th><th>Valor</th><th>Acoes</th></tr>
            <?php foreach ($listaProdutos_Venda as $prod_ven): ?>
                <tr>
                    <td><?= $prod_ven['id_prod'] ?></td>
                    <td><?= $prod_ven['quant'] ?></td>
                    <td>R$ <?= number_format((float) $prod_ven['valor_venda_prd'], 2, ',', '.') ?></td>
                    <td>
                        <a href="?id_venda=<?= $idVenda ?>&deletar=<?= $prod_ven['id_prod_venda'] ?>">Excluir</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <hr>
        <h3>Adicione mais Itens</h3>
        <div>
            <?php foreach ($listaProdutos as $prod): ?>
                <div>
                    <h3><?= $prod['nome_prod'] ?></h3>
                    <p>Preco: R$ <?= number_format((float) $prod['preco'], 2, ',', '.') ?></p>
                    <p>Descricao: <?= $prod['descricao'] ?></p>

                    <?php if ($venda): ?>
                        <form method="POST">
                            <input type="hidden" name="id_venda" value="<?= $idVenda ?>">
                            <input type="hidden" name="id_prod" value="<?= $prod['id_prod'] ?>">
                            <input type="number" name="quant" min="1" value="1" required>
                            <button type="submit" name="inserir">Adicionar</button>
                        </form>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>
