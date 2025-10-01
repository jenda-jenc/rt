<?php

namespace App\Database;

use PDO;
use PDOException;

class Connection
{
    private static ?PDO $pdo = null;

    public static function get(): PDO
    {
        if (self::$pdo instanceof PDO) {
            return self::$pdo;
        }

        $mysqlHost = getenv('DB_HOST');
        $mysqlDatabase = getenv('DB_DATABASE');

        if ($mysqlHost && $mysqlDatabase) {
            $mysqlPort = getenv('DB_PORT');
            $mysqlCharset = getenv('DB_CHARSET') ?: 'utf8mb4';

            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', $mysqlHost, $mysqlDatabase, $mysqlCharset);
            if ($mysqlPort) {
                $dsn .= ';port=' . $mysqlPort;
            }

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];

            if (defined('PDO::MYSQL_ATTR_INIT_COMMAND')) {
                $options[PDO::MYSQL_ATTR_INIT_COMMAND] = sprintf('SET NAMES %s', $mysqlCharset);
            }

            $username = getenv('DB_USERNAME') ?: null;
            $password = getenv('DB_PASSWORD') ?: null;
        } elseif ($databaseUrl = getenv('DATABASE_URL')) {
            $dsn = $databaseUrl;
            $options = [];
            $username = null;
            $password = null;
        } else {
            $dbPath = __DIR__ . '/../../var/database.sqlite';
            if (!is_dir(dirname($dbPath))) {
                mkdir(dirname($dbPath), 0775, true);
            }
            $dsn = 'sqlite:' . $dbPath;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
            $username = null;
            $password = null;
        }

        try {
            self::$pdo = new PDO($dsn, $username, $password, $options);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException('Nepodařilo se připojit k databázi: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }

        Migrator::migrate(self::$pdo);

        return self::$pdo;
    }
}
