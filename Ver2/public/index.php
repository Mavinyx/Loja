<?php

require_once __DIR__ . '/../vendor/autoload.php';
use App\Core\Roteador;
$roteador = new Roteador;
$roteador->execute();