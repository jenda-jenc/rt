<?php

namespace App\Repositories;

use PDO;

class ContactInfoRepository extends Repository
{
    /**
     * @return array<string, string|null>
     */
    public function get(): array
    {
        $stmt = $this->pdo->query('SELECT phone, email, facebook, address, reservation_note FROM contact_info WHERE id = 1');
        $info = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        return array_merge([
            'phone' => '',
            'email' => '',
            'facebook' => '',
            'address' => '',
            'reservation_note' => '',
        ], $info);
    }

    /**
     * @param array<string, string|null> $data
     */
    public function save(array $data): void
    {
        $params = [
            ':phone' => $data['phone'] ?? null,
            ':email' => $data['email'] ?? null,
            ':facebook' => $data['facebook'] ?? null,
            ':address' => $data['address'] ?? null,
            ':reservation_note' => $data['reservation_note'] ?? null,
        ];

        $existsStmt = $this->pdo->query('SELECT 1 FROM contact_info WHERE id = 1');
        $exists = $existsStmt && $existsStmt->fetchColumn();

        if ($exists) {
            $stmt = $this->pdo->prepare('UPDATE contact_info SET phone = :phone, email = :email, facebook = :facebook, address = :address, reservation_note = :reservation_note, updated_at = CURRENT_TIMESTAMP WHERE id = 1');
            $stmt->execute($params);
        } else {
            $insert = $this->pdo->prepare('INSERT INTO contact_info (id, phone, email, facebook, address, reservation_note) VALUES (1, :phone, :email, :facebook, :address, :reservation_note)');
            $insert->execute($params);
        }
    }
}
