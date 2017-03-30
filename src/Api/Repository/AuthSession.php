<?php
declare(strict_types=1);

namespace Api\Repository;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DBALException;
use Api\Exception\DatabaseException;

class AuthSession
{
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function create(array $data)
    {
        try {
            $this->connection->insert('auth_session', $data);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }
    }

    public function update(array $data, array $criteria)
    {
        try {
            $this->connection->update('auth_session', $data, $criteria);
        } catch (DBALException $exception) {
            throw new DatabaseException($exception->getMessage());
        }
    }

    public function findByToken($token)
    {
        $query = $this->connection->executeQuery('SELECT * FROM auth_session WHERE token = ?', [$token]);

        $session = $query->fetch();
        
        return $session;
    }
}
