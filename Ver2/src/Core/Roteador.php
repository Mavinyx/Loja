<?php
namespace App\Core;
class Roteador{
    function execute(){
        $modulo = ucfirst($_GET['modulo']);
        $acao = $_GET['acao'];

        $nome = "Controller" . $modulo;
        $arquivo = "App\\Controller\\" . $nome;
        if(file_exists($arquivo)){
            require_once $arquivo;
        }
        if(class_exists($arquivo)){
            $controller = new $arquivo();

            if(method_exists($arquivo, $acao)){
                $controller->$acao();
            }

            else{
                echo "[debug]metodo";
            }
        }else{
            echo "[debug]classe";
            echo $arquivo;
        }
    }
}
   