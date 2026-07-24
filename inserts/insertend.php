<?php
require_once "../conn.php";
$tabela = "endereco";
$campoId = "id_end";
require_once __DIR__ . "/cabeçalho.php";
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
        <input type="hidden" name="acao" value="<?= $acao ?>">
        <input type="hidden" name="formulario" value="endereco">

        <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>
        
        <select name="id_user" id="id_user" value="<?= $registro['id_user'] ?? '' ?>">
        <?php  
            foreach($pdo->query("SELECT id_user, nome_user FROM usuario") as $row){
                echo "<option value='" . $row['id_user'] . "'>" . $row['nome_user'] . "</option>";
            }
         ?>
        </select>
        <label for="cep">CEP <input type="text" name="cep" value="<?= $registro['cep'] ?? '' ?>"></label>
        <label for="numero">Número <input type="text" name="numero" value="<?= $registro['numero'] ?? '' ?>"></label>
        <label for="cidade">Cidade <input type="text" name="cidade" value="<?= $registro['cidade'] ?? '' ?>"></label>
        <label for="estado">Estado <input type="text" name="estado" value="<?= $registro['estado'] ?? '' ?>"></label>
        <button type='submit'>Cadastrar Endereço</button>
    </form>

    <table border>
        <tr>
            <th>CEP</th>
            <th>NUMERO</th>
            <th>CIDADE</th>
            <th>ESTADO</th>
            <th>Ações</th>
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
                  <td>
                    <a href="../deletar.php?formulario=endereco&id=<?= $end['id_end'] ?>">[x]</a> 
                    <a href="insertend.php?id=<?= $end['id_end'] ?>">[a]</a> 
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
