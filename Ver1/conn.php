<?php
$dsn = 'mysql:host=localhost;dbname=lojafix;charset=utf8';
$user = 'root';
$senha = '';

try {
$pdo = new PDO($dsn, $user, $senha);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}