<?php

namespace Backend\Api\Repository;

use Exception; 

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
}
