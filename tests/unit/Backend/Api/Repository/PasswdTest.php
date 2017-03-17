<?php

namespace Backend\Api\Repository;

use PHPUnit\Framework\TestCase;
use Exception;

class PasswdTest extends TestCase
{
    public function testShouldTokenizePassword()
    {
        $password = '123';

        $passwd = new Passwd;

        $this->assertTrue(password_verify($password, $passwd->tokenize($password)));
    }
}
