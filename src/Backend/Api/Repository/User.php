<?php
declare(strict_types=1);

namespace Backend\Api\Repository;

use Doctrine\DBAL\Connection;

class User
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        $this->connection->insert('user', $data);
     
        $lastInsertId = $this->connection->lastInsertId();

        return ['id' => $lastInsertId] + $data;
    }
    
    public function findByEmail($email)
    {
        $query = $this->connection->executeQuery('SELECT * FROM user WHERE email = ?', [$email]);

        $user = $query->fetch();

        return $user;
    }

    public function findByUsername($username)
    {
        $query = $this->connection->executeQuery('SELECT * FROM user WHERE username = ?', [$username]);

        $user = $query->fetch();

        return $user;
    }
}
