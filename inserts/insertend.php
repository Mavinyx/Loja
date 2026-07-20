<?php
include "../conn.php"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Endereço</title>
</head>
<body>
    <form action="inserts.php" method="post">
        <input type="hidden" name="formulario" value="endereco">
        <select name="id_user" id="id_user">
        <?php  
            foreach($pdo->query("SELECT id_user, nome_user FROM usuario") as $row){
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
         ?>
        </select>
        <label for="cep">CEP <input type="text" name="cep"></label>
        <label for="numero">Número <input type="text" name="numero"></label>
        <label for="cidade">Cidade <input type="text" name="cidade"></label>
        <label for="estado">Estado <input type="text" name="estado"></label>
        <button type='submit'>Cadastrar Endereço</button>
    </form>

    <table border>
        <tr>
            <th>CEP</th>
            <th>NUMERO</th>
            <th>CIDADE</th>
            <th>ESTADO</th>
        <tr>
    <?php

    try{
        $sql="SELECT * FROM endereco ORDER BY id_end DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $enderecos = $stmt->fetchAll();

    
        foreach($enderecos as $end):
            ?>
            <tr>
                <td>
                    <?= $end['cep'] ?>
                </td>
                <td>
                    <?= $end['numero'] ?>
                </td>
                <td>
                    <?= $end['cidade'] ?>
                </td>
                <td>
                    <?= $end['estado'] ?>
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