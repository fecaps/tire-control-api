<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Model
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('model', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $this->connection->lastInsertId();

        return $data;
    }

    public function findByName($name)
    {
        $query = $this->connection->executeQuery('SELECT * FROM model WHERE name = ?', [$name]);

        $model = $query->fetch();

        return $model;
    }
}
