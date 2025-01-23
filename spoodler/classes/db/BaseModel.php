<?php

namespace classes\db;

use PDO;
use classes\api\exception\client\NotFoundException;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = DbConnection::getInstance();
    }

    abstract protected function getTableName(): string;

    public function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM " . $this->getTableName());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->getTableName() . " WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: throw new NotFoundException('Element not found for id=' . $id);
    }

    public function create(array $data): int
    {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));

        $sql = "INSERT INTO " . $this->getTableName() . " ($columns) VALUES ($placeholders)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    // public function update(int $id, array $data): bool
    // {
    //     $setClause = implode(", ", array_map(fn($key) => "$key = :$key", array_keys($data)));

    //     $sql = "UPDATE " . $this->getTableName() . " SET $setClause WHERE id = :id";
    //     $stmt = $this->db->prepare($sql);
    //     $data['id'] = $id;

    //     return $stmt->execute($data);
    // }

    // public function delete(int $id): bool
    // {
    //     $stmt = $this->db->prepare("DELETE FROM " . $this->getTableName() . " WHERE id = :id");
    //     return $stmt->execute(['id' => $id]);
    // }
}
