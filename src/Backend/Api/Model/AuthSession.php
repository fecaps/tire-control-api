<?php
declare(strict_types=1);

namespace Backend\Api\Model;

use Backend\Api\Repository\AuthSession as AuthSessionRepository;

class AuthSession
{
    private $repository;

    public function __construct(AuthSessionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $sessionData)
    {
        $this->repository->create($sessionData);
    }
}
