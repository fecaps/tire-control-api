<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Type
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('tire_type', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findByName($name)
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_type WHERE name = ?', [$name]);

        $type = $query->fetch();

        return $type;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire_type');

        $type = $query->fetchAll();

        return $type;
    }
}
