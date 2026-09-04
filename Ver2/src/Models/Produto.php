<?php
namespace App\Models;
use App\Core\Model;
use InvalidArgumentException;

class Produto extends Model
{
    protected static string $table = 'produto';
    protected static string $pk = 'id_prod';

    public function validate(): void
    {
    if (strlen(trim($this->nome_prod))<=1) {
        throw new InvalidArgumentException(
            'O nome do produto é obrigatório e precisa ter pelo menos 2 caracteres.'
        );
    }

    if ($this->preco < 0) {
        throw new InvalidArgumentException(
            'O preço não pode ser negativo.'
        );
    }

    if ($this->estoque < 0) {
        throw new InvalidArgumentException(
            'O estoque não pode ser negativo.'
        );
    }
}
}