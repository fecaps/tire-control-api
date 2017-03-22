<?php
declare(strict_types=1);

namespace Backend\Api\Auth;

use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testShouldCreateSession()
    {
        $mockModel = $this
            ->getMockBuilder('Backend\\Api\\Model\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $mockModel
            ->expects($this->once())
            ->method('create')
            ->willReturn(null);

        $session = new Session($mockModel);

        $data = $session->create('testUserId');

        $this->assertEquals(['token', 'created_at', 'expire_at', 'user_id', 'user_ip'], array_keys($data));
    }
}
