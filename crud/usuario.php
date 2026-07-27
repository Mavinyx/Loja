<?php
require_once __DIR__ . "/../conn.php";
$tabela = "usuario";
$campoId = "id_user";
require_once __DIR__ . "/../includes/cabecalho.php";
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
</head>
<body>
    <form action="../actions/salvar.php" method="post">
        <input type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="<?= $tabela ?>">

        <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>
  
        <label for="nome">Nome: <input type="text" name="nome_user"  value="<?= $registro['nome_user'] ?? '' ?>"></label>
        <label for="email">Email: <input type="text" name="email" value="<?= $registro['email'] ?? '' ?>"></label>
        <button type='submit'>Criar Usuario</button>
    </form>
 </form>
     <table border>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
          
        <tr>
    <?php

    try{
        $sql="SELECT * FROM usuario ORDER BY id_user DESC";
        $stmt=$pdo->prepare($sql);
        $stmt->execute();
        $usuarios = $stmt->fetchAll();

    
        foreach($usuarios as $usuario):
            ?>
            <tr>
                <td>
                    <?= $usuario['nome_user'] ?>
                </td>
                <td>
                    <?= $usuario['email'] ?>
                </td>
                <td>
                    <a href="../actions/deletar.php?formulario=usuario&id=<?= $usuario['id_user'] ?>">[x]</a> 
                    <a href="usuario.php?id=<?= $usuario['id_user'] ?>">[a]</a> 
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
