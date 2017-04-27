<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;
use Api\Validator\AuthSession as AuthSessionValidator;
use DateTime;

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

        $validator = new AuthSessionValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($data);

        $model = new AuthSession($validator, $mockRepository);

        $model->create($data);
    }

    public function testShouldUpdateAuthSession()
    {
        $data       = ['expire_at'  => '2017-03-22 14:50:30'];
        $criteria   = ['token'      => 'aValidToken'];

        $validator = new AuthSessionValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['update'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('update')
            ->with($data, $criteria);

        $model = new AuthSession($validator, $mockRepository);

        $model->update($criteria['token'], $data);
    }

    public function testShouldReturnFalseIfTokenDoesNotExist()
    {
        $token = 'ABC';

        $validator = new AuthSessionValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['findByToken'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByToken')
            ->with($token)
            ->willReturn(false);

        $model = new AuthSession($validator, $mockRepository);

        $this->assertFalse($model->check($token));
    }

    public function testShouldReturnTrueIfCurrentDateIsLessThanExpireAtDate()
    {
        $token = 'ABC';
        $futureExpireAt = (new DateTime())->modify('+3 days');

        $retrieveData = [
            'token'     => $token,
            'expire_at' => $futureExpireAt->format('Y-m-d H:i:s')
        ];

        $validator = new AuthSessionValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['findByToken'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByToken')
            ->with($token)
            ->willReturn($retrieveData);

        $model = new AuthSession($validator, $mockRepository);

        $this->assertTrue($model->check($token));
    }

    public function testShouldReturnFalseIfCurrentDateIsMoreThanExpireAtDate()
    {
        $token = 'ABC';
        $futureExpireAt = (new DateTime())->modify('-1 second');

        $retrieveData = [
            'token'     => $token,
            'expire_at' => $futureExpireAt->format('Y-m-d H:i:s')
        ];

        $validator = new AuthSessionValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\AuthSession')
            ->disableOriginalConstructor()
            ->setMethods(['findByToken'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByToken')
            ->with($token)
            ->willReturn($retrieveData);

        $model = new AuthSession($validator, $mockRepository);

        $this->assertFalse($model->check($token));
    }
}
