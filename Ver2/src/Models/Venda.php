<?php
namespace App\Models;
use App\Core\Model;

class Venda extends Model
{
    protected static string $table = 'venda';
    protected static string $pk = 'id_venda';

    public function atualizarTotal(float $valor): bool
    {
        $totalAtual = (float) ($this->valor_tot ?? 0);
        $this->valor_tot = max(0, $totalAtual + $valor);

        return $this->save();
    }
}
