<?php

abstract class ModeL{

protected static ?PDO $pdo = null; //? significa que a variável pode ser de dois tipos PDO ou nulo
//configs da tabela
protected static String $table = '';
protected static String $pk = 'id';

protected array $attributes = [];

public static function setConnection(PDO $pdo): void{
        self::$pdo = $pdo;
}

public function __set(string $key, $value){
    $this->attributes[$key]=$value;
}

public function __get(string $key, $value){
    return $this->attributes[$key] ?? null;
}

public function find(int $id): ?static //retorna um objeto da classe que chamou o método
{
    $sql = sprintf("SELECT * FROM %s WHERE %s = :id LIMIT 1", static::$table,static::$pk);
    $stmt=self::$pdo->prepare($sql);
    $stmt->execute(['id'=>$id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$data){
        return null;
    }
    $instancia = new static();
    $instancia->attibutes =$data;
    return $instancia;
}
}