<?php
namespace App\Models;
use App\Core\Model;

class Usuario extends Model
{
    protected static string $table = 'usuario';
    protected static string $pk = 'id_user';
}