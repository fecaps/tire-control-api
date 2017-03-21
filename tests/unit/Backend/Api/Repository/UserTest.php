<?php
declare(strict_types=1);

namespace Backend\Api\Repository;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class UserTest extends TestCase
{
    public function testShouldFindOneUserByEmail()
    {
        $expectedUserData = [
            'name'      => 'Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'password'  => '123'
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetchAll'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedUserData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM user WHERE email = ?', [$expectedUserData['email']])
            ->willReturn($mockQuery);

        $repositoryUser = new User($mockConnection);

        $retrieveData = $repositoryUser->findByEmail($expectedUserData['email']);

        $this->assertEquals($expectedUserData, $retrieveData);
    }

    public function testShouldFindOneUserByUsername()
    {
        $expectedUserData = [
            'name'      => 'Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'password'  => '123'
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetchAll'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedUserData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM user WHERE username = ?', [$expectedUserData['username']])
            ->willReturn($mockQuery);

        $repositoryUser = new User($mockConnection);

        $retrieveData = $repositoryUser->findByUsername($expectedUserData['username']);

        $this->assertEquals($expectedUserData, $retrieveData);
    }

    public function testShouldCreateAnUser()
    {
        $userData = [
            'name'      => 'Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'passwd'    => '123'
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'lastInsertId'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('user', $userData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repositoryUser = new User($mockConnection);

        $retrieveUserData = $repositoryUser->create($userData);

        $expectedUserData = ['id' => 2] + $userData;

        $this->assertEquals($expectedUserData, $retrieveUserData);
    }
}
