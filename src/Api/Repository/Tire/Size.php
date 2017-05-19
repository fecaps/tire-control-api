<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Size
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('tire_size', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findById($id)
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_size WHERE id = ?', [$id]);

        $size = $query->fetch();

        return $size;
    }

    public function findByName($name)
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_size WHERE name = ?', [$name]);

        $size = $query->fetch();

        return $size;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_size');

        $size = $query->fetchAll();

        return $size;
    }
}
