<?php
declare(strict_types=1);

namespace Api\Repository;

use Doctrine\DBAL\Connection;

class AuthSession
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data)
    {
        $this->connection->insert('auth_session', $data);
    }

    public function update(array $data, array $criteria)
    {
        $this->connection->update('auth_session', $data, $criteria);
    }

    public function findByToken($token)
    {
        $query = $this->connection->executeQuery('SELECT * FROM auth_session WHERE token = ?', [$token]);

        $session = $query->fetch();
        
        return $session;
    }
}
