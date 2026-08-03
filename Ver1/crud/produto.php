<?php
require_once __DIR__ . "/../conn.php";
$tabela = "produto";
$campoId = "id_prod";
require_once __DIR__ . "/../includes/cabecalho.php";
?>
<!DOCTYPE html>
<html lang="en" data-theme="retro">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produtos</title>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body>
    <h1 class="font-title text-4xl font-bold text-center">PRODUTOS</h1>
    
    <form action="../actions/salvar.php" method="post" class="max-w-md mx-auto">
    <div class="card-body">
        <input  type="hidden" name="acao" value="<?= $acao ?>">

        <input type="hidden" name="formulario" value="<?= $tabela ?>">

         <?php if ($acao == 2 && isset($registro[$campoId])): ?>
        <input type="hidden" name="<?= $campoId ?>" value="<?= $registro[$campoId] ?>">
        <?php endif; ?>

        <select class="select w-100" name="id_forn" id="id_forn"  value="<?= $registro['id_forn'] ?? '' ?>" >
        <?php  
            foreach($pdo->query("SELECT id_forn, nome_forn FROM fornecedor") as $row){
                echo "<option value='" . $row['id_forn'] . "'>" . $row['nome_forn'] . "</option>";
            }
         ?>
        </select>
        <select class="select w-100" name="id_cat" id="id_cat" value="<?= $registro['id_cat'] ?? '' ?>">
        <?php  
            foreach($pdo->query("SELECT id_cat, nome_cat FROM categoria") as $row){
                echo "<option value='" . $row['id_cat'] . "'>" . $row['nome_cat'] . "</option>";
            }
         ?>
        </select>
        <label for="nome_prod" class="label">Nome do Produto</label><input class="input w-100" type="text" name="nome_prod" value="<?= $registro['nome_prod'] ?? '' ?>">
        <label for="preco" class="label">Preço</label><input type="number" class="input w-100" step="0.01" min="0" name="preco" value="<?= $registro['preco'] ?? '' ?>">
        <label for="descricao" class="label">Descricao</label><input type="text" class="input w-100" name="descricao" value="<?= $registro['descricao'] ?? '' ?>">
        <label for='estoque' class="label">Estoque</label><input type="number" class="input w-100" min="0" name='estoque' value="<?= $registro['estoque'] ?? '' ?>">
        <button type='submit' class='btn btn-secondary'>Enviar</button>

    </form>
        </div>
     <table class="table w-[50%] mx-auto ">
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
                    <a class="btn btn-primary" href="../actions/deletar.php?formulario=produto&id=<?= $prod['id_prod'] ?>">excluir</a> 
                    <a class="btn" href="produto.php?id=<?= $prod['id_prod'] ?>">editar</a> 
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
