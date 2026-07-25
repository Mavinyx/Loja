<?php
require_once "../conn.php";
$tabela = "venda";
$campoId = "id_venda";
require_once __DIR__ . "/cabeçalho.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Venda</title>
</head>
<body>
     <form action="inserts.php" method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="<?= $tabela ?>">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>

        Comprador<select name="id_user" id="id_user" value="<?= $registro['id_user'] ?? '' ?>" >
        <?php  
            foreach($pdo->query("SELECT id_user, nome_user FROM usuario") as $row){
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
         ?>
        </select>
        <input type="hidden" name="valor_tot" value="<?= $registro['valor_tot'] ?? '' ?>">
        <label for="data_ped">Data <input type="date" name="data_ped" value="<?= $registro['data_ped'] ?? '' ?>"></label>
        <button type='submit'>Registrar Venda</button>

    </form>

        <table border>
        <tr>
            <th>Comprador</th>
            <th>Preço Total</th>
            <th>Data</th>
            <th>Adicionar Produtos</th>
            <th>Ações</th>
        <tr>

     <?php

    try{
        $sql="SELECT * FROM venda ORDER BY id_venda DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $vendas = $stmt->fetchAll();

    //Arrumar isso aqui dps, nao ta exibindo nome
        foreach($vendas as $venda):
            ?>
            <tr>
                
                <td>
                   <?php
                    $stmt = $pdo->query("SELECT u.nome_user FROM venda v join usuario u on u.id_user=v.id_user WHERE v.id_venda = " . $venda['id_venda']);
                    $comprador = $stmt->fetch();
                    echo $comprador['nome_user'];
                   ?>
                </td>
                <td>
                    <?= $venda['valor_tot'] ?>
                </td>
                <td>
                    <?= $venda['data_ped'] ?>
                </td>
                <td>
                   <a href="form_prodvenda.php?id_venda=<?= $venda['id_venda'] ?>">Add Items</a>
                </td>
                <td>
                    <a href="../deletar.php?formulario=venda&id=<?= $venda['id_venda'] ?>">[x]</a> 
                    <a href="insertvenda.php?id=<?= $venda['id_venda'] ?>">[a]</a>
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