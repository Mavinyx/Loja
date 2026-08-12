<?php
namespace App\Models;
use App\Core\Model;

class Endereco extends Model
{
    protected static string $table = 'endereco';
    protected static string $pk = 'id_end';

    public static function findByUsuario(int $idUser): ?static
    {
        $sql = sprintf("SELECT * FROM %s WHERE id_user = :id_user LIMIT 1", static::$table);
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute(['id_user' => $idUser]);

        $data = $stmt->fetch();

        if (!$data) {
            return null;
        }

        $instance = new static();
        $instance->attributes = $data;

        return $instance;
    }

    public static function deleteByUsuario(int $idUser): bool
    {
        $sql = sprintf("DELETE FROM %s WHERE id_user = :id_user", static::$table);
        $stmt = self::getPDO()->prepare($sql);

        return $stmt->execute(['id_user' => $idUser]);
    }
}
