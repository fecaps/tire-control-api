<?php
declare(strict_types=1);

namespace Backend\Api\Model;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testShouldCreateNewUser()
    {
        $userData = [
            'name'      => 'Test Name',
            'email'     => 'test@gmail.com',
            'username'  => 'testUsername',
            'passwd'    => '123456'
        ];

        $mockRepository = $this
            ->getMockBuilder('Backend\\Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->setMethods(['findByEmail', 'findByUsername', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($userData['email'])
            ->willReturn(null);

        $mockRepository
            ->expects($this->once())
            ->method('findByUsername')
            ->with($userData['username'])
            ->willReturn(null);

        $newUserData = ['id' => 123] + $userData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($userData)
            ->willReturn($newUserData);

        $userModel = new User($mockRepository);

        $retrieveData = $userModel->create($userData);

        $this->assertEquals($newUserData, $retrieveData);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage This email is already in use
     */
    public function testShouldGetErrorWhenEmailIsAlreadyInUse()
    {
        $userData = [
            'name'      => 'Test Name',
            'email'     => 'test@gmail.com',
            'username'  => 'newTestUsername',
            'passwd'    => '123456'
        ];

        $mockRepository = $this
            ->getMockBuilder('Backend\\Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->setMethods(['findByEmail'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($userData['email'])
            ->willReturn($userData);

        $userModel = new User($mockRepository);

        $userModel->create($userData);
    }
}
