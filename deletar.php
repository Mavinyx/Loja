<?php
require_once 'conn.php';

$ids = [
    "produto" => "id_prod",
    "usuario" => "id_user",
    "fornecedor" => "id_forn",
    "categoria" => "id_cat",
    "endereco" => "id_end"
];

$tabela = $_GET['formulario'] ?? '';

// INPUT_GET -> especifica que o valor deve vir de uma requisição GET
// FILTER_VALIDATE_INT -> valida se o valor é um inteiro
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!isset($ids[$tabela]) || $id === false || $id === null) {
    echo "Tabela ou id invalido";
    exit;
}

$campoId = $ids[$tabela];

try {
    //usar o placeholder pra evitar sql injection
    $sql="DELETE FROM $tabela WHERE $campoId = :id";
    $stmt=$pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    header("Location: " . ($_SERVER['HTTP_REFERER'] ?? 'index.php'));
    exit;
}catch(PDOException $e){
     echo "erro $e";
}
