<?php

namespace Backend\Api\Repository;

use Doctrine\DBAL\Connection;

class User
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function findByEmail($email)
    {
        $sentence = $this->connection->executeQuery('SELECT * FROM user where email = ?', [$email]);

        $user = $sentence->fetchAll();

        return $user;
    }

    public function create(array $data): array
    {
        $this->connection->insert('user', $data);
     
        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }
}
