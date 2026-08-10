<?php
require_once __DIR__ . '/../../../../vendor/autoload.php';
use App\Models\Prod_Venda;
use App\Models\Produto;
$listaProdutos_Venda = Prod_Venda::all();
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
    <h3>Seus itens no carrinho</h3>
    <div>
    <table border='1'>
        <tr><th>Produto</th><th>Quantidade</th><th>Valor</th></tr>
    <?php foreach($listaProdutos_Venda as $prod_ven): //vou ter que arrumar dps pq ta mostrando todos os produtos(aula da raissa chegou)?>
        <tr>
            <td><?= $prod_ven['id_prod']?></td>
            <td><?= $prod_ven['quant']?></td>
            <td><?= $prod_ven['valor_venda_prd']?></td>
        </tr>
    <?php endforeach;?>
    </table>
  
    <hr>
    <h3>Adicione mais Itens</h3>
   <div>
    <?php foreach($listaProdutos as $prod):?>
    <div>
        <h3><?= $prod['nome_prod']?></h3>
        <p>Preço: R$ <?= number_format($prod['preco'], 2, ',', '.')?></p>
        <P>Descrição: <?= $prod['descricao']?></P>
    </div>
    <?php endforeach;?>
   </div>
</body>
</html>