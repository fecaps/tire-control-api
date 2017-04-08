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
            $this->connection->insert('type', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $this->connection->lastInsertId();

        return $data;
    }

    public function findByName($name)
    {
        $query = $this->connection->executeQuery('SELECT * FROM type WHERE name = ?', [$name]);

        $type = $query->fetch();

        return $type;
    }
}
