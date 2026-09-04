<?php
namespace App\Models;
use App\Core\Model;
use PDO;

class Prod_Venda extends Model
{
    protected static string $table = 'prod_venda';
    protected static string $pk = 'id_prod_venda';

    public static function all(?int $idVenda = null): array
    {
        if ($idVenda === null) {
            return parent::all();
        }

        $sql = sprintf("SELECT * FROM %s WHERE id_venda = :id_venda", static::$table);
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute(['id_venda' => $idVenda]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public static function verifyProduct(?int $id_prod = null, ?int $id_venda = null) : array {
        if($id_prod === null){
            return [];
        }

        $query =  sprintf("SELECT * FROM %s 
         WHERE id_prod = :id_prod 
         AND id_venda = :id_venda",
        static::$table);
        $stmt =self::getPDO()->prepare($query);
        $stmt->execute([':id_prod'=> $id_prod, ':id_venda' => $id_venda]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
