<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\User as UserValidator;
use Api\Repository\User as UserRepository;
use Api\Repository\Passwd;
use Api\Exception\ValidatorException;

class User
{
    private $validator;
    private $repository;
    private $passwd;

    public function __construct(UserValidator $validator, UserRepository $repository, Passwd $passwd)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->passwd = $passwd;
    }

    public function create(array $userData): array
    {
        $exception = new ValidatorException;

        $this->validator->sanitizeInputData($userData);

        $email = $userData['email'];

        $existsEmail = $this->repository->findByEmail($email);

        if ($existsEmail) {
            $exception->addMessage('email', 'Email already in use.');
        }

        $username = $userData['username'];

        $existsUsername = $this->repository->findByUsername($username);

        if ($existsUsername) {
            $exception->addMessage('username', 'Username already in use.');
        }

        if (count($exception->getMessages()) > 0) {
            throw $exception;
        }

        $userData['passwd'] = $this->passwd->tokenize($userData['passwd']);

        return $this->repository->create($userData);
    }
}
