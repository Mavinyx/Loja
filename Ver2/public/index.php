<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Core\Connection;
use App\Models\Usuario;
use App\Models\Fornecedor;
use App\Models\Produto;
use App\Models\Venda;
use App\Models\Endereco;
use App\Models\Categoria;

try {
    $pdo = Connection::getInstance();
    echo "Conectado!!";
} catch (Exception $e) {
    echo "Falha na fundação: " . $e->getMessage();
}
/*
try {
    
    $novoUsuario = new Usuario();
    $novoUsuario->nome_user = "teste";
    $novoUsuario->email = "teste@gmail.com";
    $novoUsuario->save();

    echo "Sucesso! Registro salvo com o ID: " . $novoUsuario->id_user . "<br>";

    $usuarioSalvo = Usuario::find($novoUsuario->id_user);
    echo "Nome resgatado do banco: " . $usuarioSalvo->nome_user;

} catch (Exception $e) {
    echo "Erro na operação: " . $e->getMessage();
}
    */

