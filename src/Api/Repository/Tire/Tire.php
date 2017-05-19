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
        $query = $this->connection->executeQuery('
            SELECT a.id, b.name as brand, c.name as model, 
            d.name as size, e.name as type, a.dot, a.code, 
            a.purchase_price, a.purchase_date FROM tire a 
            LEFT JOIN tire_brand b ON a.brand_id = b.id
            LEFT JOIN tire_model c ON a.model_id = c.id
            LEFT JOIN tire_size d ON a.size_id = d.id
            LEFT JOIN tire_type e ON a.type_id = e.id');

        $tire = $query->fetchAll();

        return $tire;
    }
}
