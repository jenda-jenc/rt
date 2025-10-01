<?php

namespace App\Repositories;

use DateTimeImmutable;
use PDO;

class EventRepository extends Repository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function upcoming(int $limit = 12): array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM events WHERE event_date >= :today ORDER BY event_date ASC, starts_at ASC LIMIT :limit');
        $stmt->bindValue(':today', (new DateTimeImmutable())->format('Y-m-d'));
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM events ORDER BY event_date DESC, starts_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM events WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $event = $stmt->fetch(PDO::FETCH_ASSOC);

        return $event ?: null;
    }

    public function save(array $data): int
    {
        if (!empty($data['id'])) {
            $stmt = $this->pdo->prepare('UPDATE events SET title = :title, description = :description, event_date = :event_date, starts_at = :starts_at, price = :price, updated_at = CURRENT_TIMESTAMP WHERE id = :id');
            $stmt->execute([
                ':title' => $data['title'],
                ':description' => $data['description'] ?? null,
                ':event_date' => $data['event_date'],
                ':starts_at' => $data['starts_at'] ?? null,
                ':price' => $data['price'] ?? null,
                ':id' => $data['id'],
            ]);
            return (int) $data['id'];
        }

        $stmt = $this->pdo->prepare('INSERT INTO events (title, description, event_date, starts_at, price) VALUES (:title, :description, :event_date, :starts_at, :price)');
        $stmt->execute([
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':event_date' => $data['event_date'],
            ':starts_at' => $data['starts_at'] ?? null,
            ':price' => $data['price'] ?? null,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM events WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
