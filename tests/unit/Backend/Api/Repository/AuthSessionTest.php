<?php
declare(strict_types=1);

namespace Backend\Api\Repository;

use PHPUnit\Framework\TestCase;

class AuthSessionTest extends TestCase
{
    public function testShouldCreateSession()
    {
        $data = [
            'token'         => 'AOBADHMDLOFNAC',
            'created_at'    => '2017-03-21 14:50:30',
            'expire_at'     => '2017-03-22 14:50:30',
            'user_id'       => '1739162',
            'user_ip'       => '127.0.0.1'
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('auth_session', $data);

        $repository = new AuthSession($mockConnection);

        $repository->create($data);
    }
}
