<?php
require_once 'conn.php';
      extract($_REQUEST);
try{
    
     $stmt = $pdo->prepare($sql);
     $stmt->execute(
        [   
            ':id_forn' => $id_forn,
            ':id_cat' => $id_cat,
            ':nome_prod' => $nome_prod,
            ':preco' => $preco,
            ':descricao' => $descricao,
            ':estoque' => $estoque,
            ':id' =>  $id
        ]
    );
    header('location: inserts/insertprod.php');
}catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}