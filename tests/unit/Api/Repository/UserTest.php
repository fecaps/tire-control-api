<?php
declare(strict_types=1);

namespace Api\Repository;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class UserTest extends TestCase
{
    public function testShouldFindByEmail()
    {
        $expectedData = [
            'name'      => 'Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'password'  => '123'
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetch'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetch')
            ->willReturn($expectedData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM users WHERE email = ?', [$expectedData['email']])
            ->willReturn($mockQuery);

        $repository = new User($mockConnection);

        $retrieveData = $repository->findByEmail($expectedData['email']);

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldFindByUsername()
    {
        $expectedData = [
            'name'      => 'Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'password'  => '123'
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetch'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetch')
            ->willReturn($expectedData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM users WHERE username = ?', [$expectedData['username']])
            ->willReturn($mockQuery);

        $repository = new User($mockConnection);

        $retrieveData = $repository->findByUsername($expectedData['username']);

        $this->assertEquals($expectedData, $retrieveData);
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
            ->with('users', $userData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repository = new User($mockConnection);

        $retrieveData = $repository->create($userData);

        $expectedData = ['id' => 2] + $userData;

        $this->assertEquals($expectedData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertSession()
    {
        $mockConn = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert'])
            ->getMock();

        $mockConn
            ->expects($this->once())
            ->method('insert')
            ->will($this->throwException(new DBALException('An error has ocurred')));

        $repository = new User($mockConn);

        $repository->create([]);
    }
}
