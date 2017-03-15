<?php

namespace Backend\Api\Model;

use Backend\Api\Repository\User as UserRepository;

class User
{
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $userData): array
    {
        return $this->repository->create($userData);
    }
}
