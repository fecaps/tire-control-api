<?php
declare(strict_types=1);

namespace Api\Repository;

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

    public function testShouldCheckPassword()
    {
        $password = '123';

        $hashPasswd = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);

        $passwd = new Passwd;

        $this->assertTrue($passwd->check($password, $hashPasswd));
    }
}
