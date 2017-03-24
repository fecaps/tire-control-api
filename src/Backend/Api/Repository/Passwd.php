<?php
declare(strict_types=1);

namespace Backend\Api\Repository;

class Passwd
{
    public function tokenize($password)
    {
        $passwordHash = password_hash(
            $password,
            PASSWORD_DEFAULT,
            ['cost' => 12]
        );

        return $passwordHash;
    }

    public function check($rawPassword, $hashPassword)
    {
        return password_verify($rawPassword, $hashPassword);
    }
}
