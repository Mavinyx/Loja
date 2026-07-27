<?php
require_once __DIR__ . "/../conn.php";
$tabela = "prod_venda";
$campoId = "id_prod_venda";
require_once __DIR__ . "/../includes/cabecalho.php";
$id_venda = $_GET['id_venda'] ?? ($registro['id_venda'] ?? '');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos da Venda</title>
</head>
<body>
    <form action="../actions/salvar.php" method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="<?= $tabela ?>">
        <input type="hidden" name="id_venda" value="<?= $id_venda ?>">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>
        <label for="id_prod">Produto:
        <select name="id_prod" id="id_prod">
            <option value="">Selecione um produto</option>
            <?php
            $stmt = $pdo->query("SELECT * FROM produto");
            $produtos = $stmt->fetchAll();
            foreach($produtos as $produto):
            ?>
                <option value="<?= $produto['id_prod'] ?>" <?= (($registro['id_prod'] ?? '') == $produto['id_prod']) ? 'selected' : '' ?>>
                    <?= $produto['nome_prod'] ?>
                </option>
            <?php
            endforeach;
            ?>
        </select></label>
        <label for="quant">Quantidade:
        <input type="number" name="quant" id="quant" min="1" value="<?= $registro['quant'] ?? 1 ?>"></label>
        <input type="hidden" name="valor_venda_prd" value="<?= $registro['valor_venda_prd'] ?? '' ?>">
        <input type="submit" value="<?= $acao == 2 ? 'Atualizar Produto' : 'Adicionar Produto' ?>">
    </form>
 <table border>
        <tr>
            <th>Nome Produto</th>
            <th>Quantidade</th>
            <th>Valor Total</th>
            <th>Ações</th>
          
        <tr>
    <?php

    try{
        $sql="SELECT * FROM prod_venda WHERE id_venda = :id_venda ORDER BY id_prod_venda DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([':id_venda' => $id_venda]);
        $produtos_venda = $stmt->fetchAll();

        //gambiarra pra atualizar o valor total do produto na venda, caso a quantidade seja alterada, porem só atualiza quando a página é recarregada, 
        // então se o usuário adicionar um produto e não atualizar a página, o valor total da venda não será atualizado( arrumar isso dps(se possível))
        updateProdutoPreco($pdo, $produtos_venda, $id_venda);
        
        foreach($produtos_venda as $prod):
            ?>
            <tr>
                <td>
                    <?php
                    $stmt = $pdo->prepare("SELECT nome_prod FROM produto WHERE id_prod = :id_prod");
                    $stmt->execute([':id_prod' => $prod['id_prod']]);
                    $produto = $stmt->fetch();
                    echo $produto['nome_prod'];
                    ?>
                </td>
                <td>
                    <?= $prod['quant'] ?>
                </td>
                <td>
                    <?= $prod['valor_venda_prd'] ?>
                </td>
                <td>
                    <a href="../actions/deletar.php?formulario=prod_venda&id=<?= $prod['id_prod_venda'] ?>">[x]</a> 
                    <a href="produto_venda.php?id=<?= $prod['id_prod_venda'] ?>&id_venda=<?= $prod['id_venda'] ?>">[a]</a> 
                </td>
            </tr>
       <?php
        endforeach;
        ?>
        </table>
        <?php
         }catch(PDOException $e){
            echo "erro:". $e->getMessage();
         }

         //calcula o valor total da venda com base nos produtos adicionados
         function updateVendaTotal($pdo, $id_venda) {
            $query = "SELECT SUM(pv.valor_venda_prd) AS total FROM prod_venda pv join venda v ON pv.id_venda = v.id_venda WHERE pv.id_venda = :id_venda";
            $stmt = $pdo->prepare($query);
            $stmt->execute([':id_venda' => $id_venda]);
            $result = $stmt->fetch();
            $updateQuery = "UPDATE venda SET valor_tot= :total WHERE id_venda = :id_venda";
            $stmt = $pdo->prepare($updateQuery);
            $stmt->execute([':total' => $result['total'], ':id_venda' => $id_venda]);
        }

        //calcula o valor total de cada produto
        function updateProdutoPreco($pdo, $produtos_venda, $id_venda) {
            foreach($produtos_venda as $prod_ven):
                $subquery="SELECT preco FROM produto WHERE id_prod = :id_prod";
                $stmt=$pdo->prepare($subquery);
                $stmt->execute([':id_prod' => $prod_ven['id_prod']]);
                $sub_produto = $stmt->fetch();
                $total = $prod_ven['quant'] * $sub_produto['preco'];
                $prod_ven['valor_venda_prd'] = $total;
                $sub_subquery="UPDATE prod_venda SET valor_venda_prd = :valor_venda_prd WHERE id_prod_venda = :id_prod_venda";
                $stmt=$pdo->prepare($sub_subquery);
                $stmt->execute([
                    ':valor_venda_prd' => $total,
                    ':id_prod_venda' => $prod_ven['id_prod_venda']
                ]);
                updateVendaTotal($pdo, $id_venda);
        endforeach;
        }
    ?>
    
</body>
</html>
