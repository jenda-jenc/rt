<?php

namespace App\Repositories;

use App\Database\Connection;
use PDO;

abstract class Repository
{
    protected PDO $pdo;

    public function __construct(?PDO $pdo = null)
    {
        $this->pdo = $pdo ?? Connection::get();
    }
}
