<?php
declare(strict_types=1);

namespace Api\Model;

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

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($data);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($data);

        $model = new AuthSession($mockValidator, $mockRepository);

        $model->create($data);
    }
}
