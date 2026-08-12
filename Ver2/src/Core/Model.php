<?php

namespace App\Core;

use PDO;

abstract class Model
{
    protected static string $table = '';
    protected static string $pk = 'id';
    protected array $attributes = [];

    protected static function getPDO(): PDO
    {
        return Connection::getInstance();
    }

    public function __set(string $key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public static function find(int $id): ?static
    {
        $sql = sprintf("SELECT * FROM %s WHERE %s = :id LIMIT 1", static::$table, static::$pk);
        
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute(['id' => $id]);
        
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$data) {
            return null;
        }

        $instance = new static();
        $instance->attributes = $data;
        
        return $instance;
    }

    public function save(): bool
    {

        if (isset($this->attributes[static::$pk])) {
           return $this->update(); 
        }
        
        return $this->insert();
    }

    protected function insert(): bool
    {
        $columns = array_keys($this->attributes);
        $placeholders = array_map(fn($col) => ':' . $col, $columns);

        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)",
            static::$table,
            implode(', ', $columns),
            implode(', ', $placeholders)
        );

        $stmt = self::getPDO()->prepare($sql);
        $success = $stmt->execute($this->attributes);

        if ($success) {
            $chave = static::$pk;
            $this->$chave = self::getPDO()->lastInsertId();
        }

        return $success;
    }

    protected function update(): bool
    {$chave = static::$pk;
    $id = $this->attributes[$chave];
    $atbAtualizar = $this->attributes;
    unset($atbAtualizar[$chave]); // tira a chave primária do array de atributos para não tentar atualizar o valor dela

    $columns = array_keys($atbAtualizar);
    $setClause = implode(', ', array_map(fn($col) => "$col = :$col", $columns)); // deixa bonitinho pra query
    $sql = sprintf(
        "UPDATE %s SET %s WHERE %s = :pk_id",
        static::$table,
        $setClause,
        $chave
    );
    $params = $atbAtualizar;
    $params['pk_id'] = $id;
    $stmt = self::getPDO()->prepare($sql);
    
    return $stmt->execute($params);
    }
    
    public static function all(): array{
        $sql = sprintf("SELECT * FROM %s", static::$table);
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete(): bool{
        if (!isset($this->attributes[static::$pk])) {
            return false;
        }

        $sql = sprintf("DELETE FROM %s WHERE %s = :id", static::$table, static::$pk);
        $stmt = self::getPDO()->prepare($sql);
        return $stmt->execute(['id' => $this->attributes[static::$pk]]);
    }
}