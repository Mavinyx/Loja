<?php
namespace App\Models;
use App\Core\Model;

class Fornecedor extends Model
{
    protected static string $table = 'fornecedor';
    protected static string $pk = 'id_forn';
}