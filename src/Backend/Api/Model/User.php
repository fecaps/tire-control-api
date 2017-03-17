<?php

namespace Backend\Api\Model;

use Backend\Api\Repository\User as UserRepository;
use Backend\Api\Repository\Passwd;
use Exception;

class User
{
    private $repository;
    private $passwd;

    public function __construct(UserRepository $repository, Passwd $passwd)
    {
        $this->repository = $repository;
        $this->passwd = $passwd;
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

        $userData['passwd'] = $this->passwd->tokenize($userData['passwd']);

        return $this->repository->create($userData);
    }
}
