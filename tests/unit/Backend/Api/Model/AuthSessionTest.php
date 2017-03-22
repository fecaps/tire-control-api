<?php
declare(strict_types=1);

namespace Backend\Api\Model;

use PHPUnit\Framework\TestCase;

class AuthSessionTest extends TestCase
{
    public function testShouldCreateAuthSession()
    {
        $data = [
            'token'         => 'AOBADHMDLOFNAC',
            'created_at'    => '2017-03-21 14:50:30',
            'expire_at'     => '2017-03-22 14:50:30',
            'user_id'       => '1739162',
            'user_ip'       => '127.0.0.1'
        ];

        $mockRepository = $this
            ->getMockBuilder('Backend\\Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($data);

        $model = new AuthSession($mockRepository);

        $model->create($data);
    }
}
