<?php
require_once __DIR__ . "/../conn.php";
if(isset($_GET['id'])){
    extract($_GET);
    $acao = 2;
    try{ 
        $sql="SELECT * FROM $tabela  WHERE $campoId = :id";
        $stmt=$pdo->prepare($sql);
        $stmt->execute([':id' => $_GET['id']]);
        $registros = $stmt->fetchAll();
        $registro = $registros[0];
    }catch(PDOException $e){
        echo "erro $e";
    }
}else{
    $acao = 1;
}
?>
