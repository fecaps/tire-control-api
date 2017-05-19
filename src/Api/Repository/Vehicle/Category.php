<?php
declare(strict_types=1);

namespace Api\Repository\Vehicle;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Category
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('vehicle_category', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findById($id)
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle_category WHERE id = ?', [$id]);

        $category = $query->fetch();

        return $category;
    }

    public function findByName($name)
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle_category WHERE name = ?', [$name]);

        $category = $query->fetch();

        return $category;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle_category');

        $category = $query->fetchAll();

        return $category;
    }
}
