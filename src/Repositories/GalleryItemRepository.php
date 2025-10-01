<?php

namespace App\Repositories;

use PDO;

class GalleryItemRepository extends Repository
{
    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM gallery_items ORDER BY position ASC, created_at DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM gallery_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        return $item ?: null;
    }

    public function save(array $data): int
    {
        if (!empty($data['id'])) {
            $stmt = $this->pdo->prepare('UPDATE gallery_items SET title = :title, image_path = :image_path, description = :description, position = :position, updated_at = CURRENT_TIMESTAMP WHERE id = :id');
            $stmt->execute([
                ':title' => $data['title'] ?? null,
                ':image_path' => $data['image_path'],
                ':description' => $data['description'] ?? null,
                ':position' => $data['position'] ?? 0,
                ':id' => $data['id'],
            ]);
            return (int) $data['id'];
        }

        $stmt = $this->pdo->prepare('INSERT INTO gallery_items (title, image_path, description, position) VALUES (:title, :image_path, :description, :position)');
        $stmt->execute([
            ':title' => $data['title'] ?? null,
            ':image_path' => $data['image_path'],
            ':description' => $data['description'] ?? null,
            ':position' => $data['position'] ?? 0,
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM gallery_items WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
