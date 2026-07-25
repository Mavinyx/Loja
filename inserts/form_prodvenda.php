<?php
require_once "../conn.php";
$tabela = "prod_venda";
$campoId = "id_prod_venda";
require_once __DIR__ . "/cabeçalho.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos da Venda</title>
</head>
<body>
    <form action="inserts.php" method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="<?= $tabela ?>">
        <input type="hidden" name="id_venda" value="<?= $_GET['id_venda'] ?? ($registro['id_venda'] ?? '') ?>">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>
        <label for="id_prod">Produto:
        <select name="id_prod" id="id_prod" value="<?= $registro['id_prod'] ?? '' ?>">
            <option value="">Selecione um produto</option>
            <?php
            $stmt = $pdo->query("SELECT * FROM produto");
            $produtos = $stmt->fetchAll();
            foreach($produtos as $produto):
            ?>
                <option value="<?= $produto['id_prod'] ?>"><?= $produto['nome_prod'] ?></option>
            <?php
            endforeach;
            ?>
        </select></label>
        <label for="quant">Quantidade:
        <input type="number" name="quant" id="quant" min="1" value="<?= $registro['quant'] ?? 1 ?>"></label>
        <input type="hidden" name="valor_venda_prd" value="<?= $registro['valor_venda_prd'] ?? '' ?>">
        <input type="submit" value="Adicionar Produto">
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
        $stmt->execute([':id_venda' => $_GET['id_venda']]);
        $produtos_venda = $stmt->fetchAll();
            //falta fazer: calcular valor total com base na quantidade e no preço do produto
    
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
                    <a href="../deletar.php?formulario=prod_venda&id=<?= $prod['id_prod_venda'] ?>">[x]</a> 
                    <a href="insertprod.php?id=<?= $prod['id_prod'] ?>">[a]</a> 
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
    ?>
    
</body>
</html>
