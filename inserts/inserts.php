<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require "../conn.php";

if($_POST){
   
    try{
        $tabela=$_POST['formulario'];
        $acao=$_POST['acao'];

        $ids = [
        "produto" => "id_prod",
        "usuario" => "id_user",
        "fornecedor" => "id_forn",
        "categoria" => "id_cat",
        "endereco" => "id_end"
        ];
        $campoId = $ids[$tabela];
        $id = $_POST[$campoId] ?? null;
        $dados = $_POST;
        unset($dados['formulario'], $dados['acao'], $dados[$campoId]);

        $colunas_array = array_keys($dados);

        if($acao==1){
           $colunas = implode(', ', $colunas_array);
            $placeholders = ':' . implode(', :', $colunas_array);
            $sql = "INSERT INTO $tabela ($colunas) VALUES ($placeholders)";
        }else if($acao==2){
          $set_partes = [];
            foreach ($colunas_array as $col) {
                $set_partes[] = "$col = :$col";
            }
            $set_upd = implode(', ', $set_partes);
            $sql = "UPDATE $tabela SET $set_upd WHERE $campoId = :id_where";
        }

        $stmt = $pdo->prepare($sql);
        foreach ($dados as $col => $valor) {
            $stmt->bindValue(":$col", $valor);
        }
        if ($acao == 2) {
            $stmt->bindValue(":id_where", $id);
        }

        $stmt->execute();
        header("Location: ../index.php");
    }catch(PDOException $e){
        echo "erro $e";
    }
}
