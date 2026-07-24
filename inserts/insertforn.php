<?php
require_once "../conn.php";
$tabela = "fornecedor";
$campoId = "id_forn";
require_once __DIR__ . "/cabeçalho.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fornecedor</title>
</head>
<body>
    <form action="inserts.php" method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="fornecedor">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>

        <label for="nome_forn">Nome Fornecedor: <input type="text" name="nome_forn" value="<?= $registro['nome_forn'] ?? '' ?>"></label>
        <label for="email">Email: <input type="email" name="email" value="<?= $registro['email'] ?? '' ?>"></label>
        <label for="endereco">Endereço: <input type="text" name="endereco" value="<?= $registro['endereco'] ?? '' ?>"></label>
        <button type='submit'>Cadastrar Fornecedor</button>
    </form>
 <table border>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Endereço</th>
            <th>Ações</th>
          
        <tr>
    <?php

    try{
        $sql="SELECT * FROM fornecedor ORDER BY id_forn DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $fornecedores = $stmt->fetchAll();

    
        foreach($fornecedores as $forn):
            ?>
            <tr>
                <td>
                    <?= $forn['nome_forn'] ?>
                </td>
                <td>
                    <?= $forn['email'] ?>
                </td>
                <td>
                    <?= $forn['endereco'] ?>
                </td>
                <td>
                    <a href="../deletar.php?formulario=fornecedor&id=<?= $forn['id_forn'] ?>">[x]</a> 
                    <a href="insertforn.php?id=<?= $forn['id_forn'] ?>">[a]</a> 
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
