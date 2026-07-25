<?php
require_once "../conn.php";
$tabela = "categoria";
$campoId = "id_cat";
require_once __DIR__ . "/cabeçalho.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Categoria</title>
</head>
<body>
    <form action="inserts.php" method="post">
       <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="<?= $tabela ?>">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>
        
        <label for="nome_cat">Nome Categoria: <input type="text" name="nome_cat" value="<?= $registro['nome_cat'] ?? '' ?>"></label>
        <label for="descricao">Descrição: <input type="text" name="descricao" value="<?= $registro['descricao'] ?? '' ?>"></label>
        <button type='submit'>Criar Categoria</button>
    </form>
 <table border>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Ações</th>
          
        <tr>
    <?php

    try{
        $sql="SELECT * FROM categoria ORDER BY id_cat DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $categorias = $stmt->fetchAll();

    
        foreach($categorias as $categoria):
            ?>
            <tr>
                <td>
                    <?= $categoria['nome_cat'] ?>
                </td>
                <td>
                    <?= $categoria['descricao'] ?>
                </td>
                <td>
                    <a href="../deletar.php?formulario=categoria&id=<?= $categoria['id_cat'] ?>">[x]</a> 
                    <a href="insertcat.php?id=<?= $categoria['id_cat'] ?>">[a]</a> 
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
