<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Tire
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('tire', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findByCode($code)
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire WHERE code = ?', [$code]);

        $code = $query->fetch();

        return $code;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM tire');

        $tire = $query->fetchAll();

        return $tire;
    }
}
