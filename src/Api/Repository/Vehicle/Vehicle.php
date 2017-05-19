<?php
declare(strict_types=1);

namespace Api\Repository\Vehicle;

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
        $query = $this->connection->executeQuery('
            SELECT a.id, b.name as brand, c.name as category,
            d.model as model, e.name as type, a.plate FROM vehicle a 
            LEFT JOIN vehicle_brand b ON a.brand_id = b.id 
            LEFT JOIN vehicle_category c ON a.category_id = c.id
            LEFT JOIN vehicle_model_brand d ON a.model_id = d.id
            LEFT JOIN vehicle_type e ON a.type_id = e.id');

        $vehicle = $query->fetchAll();

        return $vehicle;
    }
}
