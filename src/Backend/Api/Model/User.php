<?php

namespace Backend\Api\Model;

use Backend\Api\Repository\User as UserRepository;
use Exception;

class User
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $userData): array
    {
        $email = $userData['email'];

        $existsEmail = $this->repository->findByEmail($email);

        if ($existsEmail) {
            $exceptionEmail = new Exception('This email is already in use');
            throw $exceptionEmail;
        }

        $username = $userData['username'];

        $existsUsername = $this->repository->findByUsername($username);

        if ($existsUsername) {
            $exceptionUsername = new Exception('This username is already in use');
            throw $exceptionUsername;
        }

        return $this->repository->create($userData);
    }
}
