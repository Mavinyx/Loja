<?php
namespace App\Models;
use App\Core\Model;

class Produto extends Model
{
    protected static string $table = 'produto';
    protected static string $pk = 'id_prod';
}