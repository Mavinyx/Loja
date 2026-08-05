<?php
namespace App\Core;

use PDO;

class Connection
{
    private static ?PDO $instance = null;

    public static function getInstance(): PDO
    {

        if (self::$instance === null) {
            $config = require __DIR__ . '/../../config/config_db.php';
            $dsn = sprintf('%s:host=%s;dbname=%s;charset=%s', $config['driver'], $config['host'], $config['dbname'], $config['charset']);
            self::$instance = new PDO($dsn, $config['username'], $config['password']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$instance;
    }

}