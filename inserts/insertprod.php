<?php
include "../conn.php";
if(isset($_GET['id'])){
    extract($_GET);
    $acao = 2;
    try{ 
        $sql="SELECT * FROM produto WHERE id_prod = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([':id' => $_GET['id']]);
        $produtos = $stmt->fetchAll();
        $produto = $produtos[0];
    }catch(PDOException $e){
        echo "erro $e";
    }
}else{
    $acao = 1;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Produto</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="inserts.php"  method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="produto">
        <select name="id_forn" id="id_forn"  value="<?= $produto['id_forn'] ?? '' ?>" >

        <?php if ($acao == 2 && isset($produto['id_prod'])): ?>
        <input type="hidden" name="id_prod" value="<?= $produto['id_prod'] ?>">
        <?php endif; ?>
        <?php  
            foreach($pdo->query("SELECT id_forn, nome_forn FROM fornecedor") as $row){
                echo "<option value='" . $row['id_forn'] . "'>" . $row['nome_forn'] . "</option>";
            }
         ?>
        </select>
        <select name="id_cat" id="id_cat" value="<?= $produto['id_cat'] ?? '' ?>">
        <?php  
            foreach($pdo->query("SELECT id_cat, nome_cat FROM categoria") as $row){
                echo "<option value='" . $row['id_cat'] . "'>" . $row['nome_cat'] . "</option>";
            }
         ?>
        </select>
        <label for="nome_prod">Nome do Produto<input type="text" name="nome_prod" value="<?= $produto['nome_prod'] ?? '' ?>"></label>
        <label for="preco">Preço<input type="number" step="0.01" min="0" name="preco" value="<?= $produto['preco'] ?? '' ?>"></label>
        <label for="descricao">Descricao<input type="text" name="descricao" value="<?= $produto['descricao'] ?? '' ?>"></label>
        <label for='estoque'>Estoque<input type="number" min="0" name='estoque' value="<?= $produto['estoque'] ?? '' ?>"></label>
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
                    <a href="../deletar.php?id=<?= $prod['id_prod'] ?>">[x]</a> 
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