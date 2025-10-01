<?php

namespace App\Repositories;

use PDO;

class ReservationRepository extends Repository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM reservations ORDER BY created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @param array{name: string, email: string, phone: string|null, event_date: string|null, message: string} $data
     */
    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO reservations (name, email, phone, event_date, message) VALUES (:name, :email, :phone, :event_date, :message)');
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':phone' => $data['phone'],
            ':event_date' => $data['event_date'],
            ':message' => $data['message'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM reservations WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
