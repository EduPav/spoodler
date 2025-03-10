<?php

namespace classes\db;

use classes\api\exception\server\InternalServerErrorException;
use PDO;

// As this is an abstract class, most of its methods are tested in ErrorLogTableTest.php
abstract class BaseModel
{
    protected $db;

    function __construct()
    {
        $this->db = DbConnection::getInstance();
    }

    abstract protected function getTableName(): string;

    function getAll(): array
    {
        $stmt = $this->db->query("SELECT * FROM " . $this->getTableName());
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    function getById(int $id): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM " . $this->getTableName() . " WHERE id = :id");
        $stmt->execute(['id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    // Warning: In case unique field is id, use getById() instead. This will return wrong results.
    function getByUniqueField(string $field, mixed $value): ?array
    {
        $tableName = $this->getTableName();

        // Validate that the provided field is a valid column for this table.
        if (!in_array($field, $GLOBALS['config']['db']["$tableName"]['columns'])) {
            throw new InternalServerErrorException("Invalid column: $field for selection in $tableName table");
        }

        $stmt = $this->db->prepare("SELECT * FROM " . $tableName . " WHERE $field = :value");
        $stmt->execute(['value' => $value]);

        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }


    function create(array $data): int
    {
        $columns = array_keys($data);
        $this->assertValidColumns($columns);
        $this->assertRequiredColumns($columns);

        $columnsForQuery = implode(", ", $columns);
        $placeholdersForQuery = implode(", ", array_map(fn($key) => ":$key", array_keys($data)));

        $sql = "INSERT INTO " . $this->getTableName() . " ($columnsForQuery) VALUES ($placeholdersForQuery)";
        $stmt = $this->db->prepare($sql);
        $stmt->execute($data);

        return (int) $this->db->lastInsertId();
    }

    private function assertValidColumns(array $columns): void
    {
        $tableName = $this->getTableName();
        foreach ($columns as $column) {
            if (!in_array($column, $GLOBALS['config']['db']["$tableName"]['columns'])) {
                throw new InternalServerErrorException("Invalid column: $column for create in $tableName table");
            }
        }
    }

    private function assertRequiredColumns(array $columns): void
    {
        $tableName = $this->getTableName();
        foreach ($GLOBALS['config']['db']["$tableName"]['requiredColumns'] as $column) {
            if (!in_array($column, $columns)) {
                throw new InternalServerErrorException("Missing required column: $column for create in $tableName table");
            }
        }
    }

    function update(int $id, array $data): bool
    {
        $columns = array_keys($data);
        $this->assertValidColumns($columns);
        $this->assertRequiredColumns($columns);

        $setClause = implode(", ", array_map(fn($key) => "$key = :$key", $columns));

        $sql = "UPDATE " . $this->getTableName() . " SET $setClause WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $data['id'] = $id;

        $stmt->execute($data);
        if ($stmt->rowCount() === 0) {
            throw new InternalServerErrorException('Update ' . $this->getTableName() . " with id=$id failed");
        }
        return true;
    }

    function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM " . $this->getTableName() . " WHERE id = :id");

        $stmt->execute(['id' => $id]);
        if ($stmt->rowCount() === 0) {
            throw new InternalServerErrorException('Delete ' . $this->getTableName() . " with id=$id failed");
        }
        return true;
    }
}
