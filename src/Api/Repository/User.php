<?php
declare(strict_types=1);

namespace Api\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class User
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data): array
    {
        try {
            $this->connection->insert('user', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }

        $this->connection->lastInsertId();

        return $data;
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
