<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\AuthSession as AuthSessionValidator;
use Api\Repository\AuthSession as AuthSessionRepository;

class AuthSession
{
    private $validator;
    private $repository;

    public function __construct(AuthSessionValidator $validator, AuthSessionRepository $repository)
    {
        $this->validator = $validator;
        $this->repository = $repository;
    }

    public function create(array $sessionData)
    {
        $this->validator->validate($sessionData);

        $this->repository->create($sessionData);
    }
}
