<?php
declare(strict_types=1);

namespace Api\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class Vehicle
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('vehicle', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findByPlate($plate)
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle WHERE plate = ?', [$plate]);

        $plate = $query->fetch();

        return $plate;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle');

        $vehicle = $query->fetchAll();

        return $vehicle;
    }
}
