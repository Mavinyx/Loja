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
        
        $data = $stmt->fetch();

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
            // return $this->update(); 
            return false; //
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
    public static function all(): array{
        $sql = sprintf("SELECT * FROM %s", static::$table);
        $stmt = self::getPDO()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
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