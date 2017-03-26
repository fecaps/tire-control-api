<?php
declare(strict_types=1);

namespace Api\Model;

use Api\Validator\Login as LoginValidator;
use Api\Repository\User as UserRepository;
use Api\Repository\Passwd;
use Api\Exception\ValidatorException;

class Login
{
    private $validator;
    private $repository;
    private $passwd;

    public function __construct(LoginValidator $validator, UserRepository $repository, Passwd $passwd)
    {
        $this->validator = $validator;
        $this->repository = $repository;
        $this->passwd = $passwd;
    }

    public function authenticate(array $loginData): array
    {
        $this->validator->validateInputData($loginData);

        $email = $loginData['email'];
        $psswd = $loginData['passwd'];

        $user = $this->repository->findByEmail($email);

        if (!$user || !$this->passwd->check($psswd, $user['passwd'])) {
            $exception = new ValidatorException('Invalid email or password.');
            throw $exception;
        }

        unset($user['passwd']);

        return $user;
    }
}
