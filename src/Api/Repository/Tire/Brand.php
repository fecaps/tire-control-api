<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Brand
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('tire_brand', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findById($id)
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_brand WHERE id = ?', [$id]);

        $brand = $query->fetch();

        return $brand;
    }

    public function findByName($name)
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_brand WHERE name = ?', [$name]);

        $brand = $query->fetch();

        return $brand;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_brand');

        $brand = $query->fetchAll();

        return $brand;
    }
}
