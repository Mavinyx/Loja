<?php
namespace App\Controller;
use App\Models\Categoria;
class ControllerCategoria{
    function deletar(){}
    function listar(){}
    function save(){
        if($_POST) {
            $id_categoria = $_POST['id_cat'] ?? null;
            $categoria = new Categoria();
            if ($id_categoria) {
                $categoria->id_cat = $id_categoria;
            }
            $categoria->nome_cat = $_POST['nome_cat'];
            $categoria->descricao= $_POST['descricao'];
            $categoria->save();
            header('Location: painel.php');
            exit;
        }
    }
}