<?php
require_once 'conn.php';
extract($_GET);
$id = $_GET['id'];

try {
    if(isset($id)){
    //usar o placeholder pra evitar sql injection
    $sql="DELETE FROM produto WHERE id_prod = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    }
}catch(PDOException $e){
     echo "erro $e";
}