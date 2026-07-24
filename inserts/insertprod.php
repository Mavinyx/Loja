<?php
require_once "../conn.php";
$tabela = "produto";
$campoId = "id_prod";
require_once __DIR__ . "/cabeçalho.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Produto</title>
</head>
<body>
    <form action="inserts.php"  method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="produto">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>

        <select name="id_forn" id="id_forn"  value="<?= $registro['id_forn'] ?? '' ?>" >
        <?php  
            foreach($pdo->query("SELECT id_forn, nome_forn FROM fornecedor") as $row){
                echo "<option value='" . $row['id_forn'] . "'>" . $row['nome_forn'] . "</option>";
            }
         ?>
        </select>
        <select name="id_cat" id="id_cat" value="<?= $registro['id_cat'] ?? '' ?>">
        <?php  
            foreach($pdo->query("SELECT id_cat, nome_cat FROM categoria") as $row){
                echo "<option value='" . $row['id_cat'] . "'>" . $row['nome_cat'] . "</option>";
            }
         ?>
        </select>
        <label for="nome_prod">Nome do Produto<input type="text" name="nome_prod" value="<?= $registro['nome_prod'] ?? '' ?>"></label>
        <label for="preco">Preço<input type="number" step="0.01" min="0" name="preco" value="<?= $registro['preco'] ?? '' ?>"></label>
        <label for="descricao">Descricao<input type="text" name="descricao" value="<?= $registro['descricao'] ?? '' ?>"></label>
        <label for='estoque'>Estoque<input type="number" min="0" name='estoque' value="<?= $registro['estoque'] ?? '' ?>"></label>
        <button type='submit'>Cadastrar Produto</button>

    </form>
     <table border>
        <tr>
            <th>Nome</th>
            <th>Preço</th>
            <th>Ações</th>
          
        <tr>
    <?php

    try{
        $sql="SELECT * FROM produto ORDER BY id_prod DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $produtos = $stmt->fetchAll();

    
        foreach($produtos as $prod):
            ?>
            <tr>
                <td>
                    <?= $prod['nome_prod'] ?>
                </td>
                <td>
                    <?= $prod['preco'] ?>
                </td>
                <td>
                    <a href="../deletar.php?formulario=produto&id=<?= $prod['id_prod'] ?>">[x]</a> 
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
