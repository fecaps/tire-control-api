<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testShouldCreateNewUser()
    {
        $userData = [
            'name'      => 'Test Name',
            'email'     => 'test@gmail.com',
            'username'  => 'testUsername',
            'passwd'    => '12345678'
        ];

        $changedUserData = $userData;
        $changedUserData['passwd'] = '20202020';

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\User')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($userData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\User')
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

        $newUserData = ['id' => 123] + $changedUserData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($changedUserData)
            ->willReturn($newUserData);

        $mockPassword = $this
            ->getMockBuilder('Api\\Repository\\Passwd')
            ->setMethods(['tokenize'])
            ->getMock();

        $mockPassword
            ->expects($this->once())
            ->method('tokenize')
            ->with($userData['passwd'])
            ->willReturn($changedUserData['passwd']);

        $userModel = new User($mockValidator, $mockRepository, $mockPassword);

        $retrieveData = $userModel->create($userData);

        $this->assertEquals($newUserData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenEmailIsAlreadyInUse()
    {
        $userData = [
            'name'      => 'Test Name',
            'email'     => 'test@gmail.com',
            'username'  => 'newTestUsername',
            'passwd'    => '12345678'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\User')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($userData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->setMethods(['findByEmail', 'findByUsername'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($userData['email'])
            ->willReturn($userData);

        $mockRepository
            ->expects($this->once())
            ->method('findByUsername')
            ->with($userData['username'])
            ->willReturn($userData);

        $mockPassword = $this
            ->getMockBuilder('Api\\Repository\\Passwd')
            ->getMock();

        $userModel = new User($mockValidator, $mockRepository, $mockPassword);

        $userModel->create($userData);
    }
}
