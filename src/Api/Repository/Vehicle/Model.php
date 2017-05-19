<?php
declare(strict_types=1);

namespace Api\Repository\Vehicle;

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
            $this->connection->insert('vehicle_model_brand', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }

    public function findById($id)
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle_model_brand WHERE id = ?', [$id]);

        $model = $query->fetch();

        return $model;
    }

    public function findByModel($modelName)
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle_model_brand WHERE model = ?', [$modelName]);

        $model = $query->fetch();

        return $model;
    }

    public function list()
    {
        $query = $this->connection->executeQuery('SELECT * FROM vehicle_model_brand');

        $model = $query->fetchAll();

        return $model;
    }
}
