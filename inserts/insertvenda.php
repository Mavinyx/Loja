<?php
include "../conn.php"
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
        <input type="hidden" name="formulario" value="venda">
        Comprador<select name="id_user" id="id_user">
        <?php  
            foreach($pdo->query("SELECT id_user, nome_user FROM usuario") as $row){
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
         ?>
        </select>
        <input type="hidden" name="valor_tot" value="0">
        <label for="data_ped">Data <input type="date" name="data_ped"></label>
        <button type='submit'>Registrar Venda</button>

    </form>

        <table border>
        <tr>
            <th>Comprador</th>
            <th>Preço Total</th>
            <th>Data</th>
            <th>Adicionar Produtos</th>
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
                    $pdo->query("SELECT u.nome_user FROM venda v join usuario u on u.id_user=v.id_user");
                   ?>
                </td>
                <td>
                    <?= $venda['valor_tot'] ?>
                </td>
                <td>
                    <?= $venda['data_ped'] ?>
                </td>
                <td>
                   <a href="#">Add Items</a>
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