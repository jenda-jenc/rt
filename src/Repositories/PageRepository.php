<?php

namespace App\Repositories;

use PDO;

class PageRepository extends Repository
{
    public function findBySlug(string $slug): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM pages WHERE slug = :slug LIMIT 1');
        $stmt->execute([':slug' => $slug]);
        $page = $stmt->fetch(PDO::FETCH_ASSOC);

        return $page ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM pages ORDER BY title ASC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function save(array $data): int
    {
        if (!empty($data['id'])) {
            $stmt = $this->pdo->prepare('UPDATE pages SET slug = :slug, title = :title, content = :content, updated_at = CURRENT_TIMESTAMP WHERE id = :id');
            $stmt->execute([
                ':slug' => $data['slug'],
                ':title' => $data['title'],
                ':content' => $data['content'],
                ':id' => $data['id'],
            ]);
            return (int) $data['id'];
        }

        $stmt = $this->pdo->prepare('INSERT INTO pages (slug, title, content) VALUES (:slug, :title, :content)');
        $stmt->execute([
            ':slug' => $data['slug'],
            ':title' => $data['title'],
            ':content' => $data['content'],
        ]);

        return (int) $this->pdo->lastInsertId();
    }

    public function delete(int $id): void
    {
        $stmt = $this->pdo->prepare('DELETE FROM pages WHERE id = :id');
        $stmt->execute([':id' => $id]);
    }
}
