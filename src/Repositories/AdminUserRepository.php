<?php

namespace App\Repositories;

use PDO;

class AdminUserRepository extends Repository
{
    public function findByUsername(string $username): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM admin_users WHERE username = :username LIMIT 1');
        $stmt->execute([':username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }
}
