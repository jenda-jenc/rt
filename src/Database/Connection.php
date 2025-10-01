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

        $databaseUrl = getenv('DATABASE_URL');
        if ($databaseUrl) {
            $dsn = $databaseUrl;
            $options = [];
        } else {
            $dbPath = __DIR__ . '/../../var/database.sqlite';
            if (!is_dir(dirname($dbPath))) {
                mkdir(dirname($dbPath), 0775, true);
            }
            $dsn = 'sqlite:' . $dbPath;
            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
        }

        try {
            self::$pdo = new PDO($dsn, null, null, $options);
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new PDOException('Nepodařilo se připojit k databázi: ' . $e->getMessage(), (int) $e->getCode(), $e);
        }

        Migrator::migrate(self::$pdo);

        return self::$pdo;
    }
}
