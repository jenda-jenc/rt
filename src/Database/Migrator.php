<?php

namespace App\Database;

use PDO;
use RuntimeException;

class Migrator
{
    public static function migrate(PDO $pdo): void
    {
        $schemaFile = __DIR__ . '/../../database/schema.sql';
        if (!file_exists($schemaFile)) {
            throw new RuntimeException('Soubor se schématem databáze nebyl nalezen.');
        }

        $sql = file_get_contents($schemaFile);
        if ($sql === false) {
            throw new RuntimeException('Schéma databáze nelze načíst.');
        }

        if ($pdo->getAttribute(PDO::ATTR_DRIVER_NAME) === 'sqlite') {
            $pdo->exec('PRAGMA foreign_keys = ON');
        }

        $pdo->exec($sql);
    }
}
