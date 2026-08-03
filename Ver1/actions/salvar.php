<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . "/../conn.php";

if($_POST){
   
    try{
        $tabela=$_POST['formulario'];
        $acao=$_POST['acao'];

        $ids = [
        "produto" => "id_prod",
        "usuario" => "id_user",
        "fornecedor" => "id_forn",
        "categoria" => "id_cat",
        "endereco" => "id_end",
        "venda" => "id_venda",
        "prod_venda" => "id_prod_venda"
        ];
        $campoId = $ids[$tabela];
        $id = $_POST[$campoId] ?? null;
        $dados = $_POST;
        unset($dados['formulario'], $dados['acao'], $dados[$campoId]);

        if ($tabela == "prod_venda" && isset($dados['id_prod'], $dados['quant'])) {
            $stmtPreco = $pdo->prepare("SELECT preco FROM produto WHERE id_prod = :id_prod");
            $stmtPreco->execute([':id_prod' => $dados['id_prod']]);
            $produto = $stmtPreco->fetch();

            if ($produto) {
                $dados['valor_venda_prd'] = $dados['quant'] * $produto['preco'];
            }
        }

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

        if ($tabela == "prod_venda" && isset($dados['id_venda'])) {
            $stmtTotal = $pdo->prepare("SELECT SUM(valor_venda_prd) AS total FROM prod_venda WHERE id_venda = :id_venda");
            $stmtTotal->execute([':id_venda' => $dados['id_venda']]);
            $resultadoTotal = $stmtTotal->fetch();

            $stmtAtualizaVenda = $pdo->prepare("UPDATE venda SET valor_tot = :total WHERE id_venda = :id_venda");
            $stmtAtualizaVenda->execute([
                ':total' => $resultadoTotal['total'] ?? 0,
                ':id_venda' => $dados['id_venda']
            ]);
        }

        if ($tabela == "prod_venda" && isset($dados['id_venda'])) {
            header("Location: ../crud/produto_venda.php?id_venda=" . $dados['id_venda']);
        } else {
            header("Location: ../index.php");
        }
        exit;
    }catch(PDOException $e){
        echo "erro $e";
    }
}
