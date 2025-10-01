<?php

namespace App\Repositories;

use PDO;

class ContactRepository extends Repository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM contacts ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO contacts (name, email, message) VALUES (:name, :email, :message)');
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':message' => $data['message'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM contacts WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
