<?php

namespace Backend\Api\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Tester\CommandTester;

class UserCreateCommandTest extends TestCase
{
    public function testShouldCreateNewUser()
    {
        $userData = [
            'name'      => 'Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'passwd'    => '123456'
        ];

        $mockModel = $this
            ->getMockBuilder('Backend\\Api\\Model\\User')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $mockModel
            ->expects($this->once())
            ->method('create')
            ->with($userData)
            ->willReturn(['id' => 1] + $userData);

        $command = new UserCreateCommand;
        $command->setModel($mockModel);

        $commandTester = new CommandTester($command);

        $commandTester->execute($userData);

        $output = $commandTester->getDisplay();

        $expectedOutput = 'User created:'. PHP_EOL;
        $expectedOutput.= 'ID:       1'     . PHP_EOL;
        $expectedOutput.= 'Name:     '      . $userData['name']     . PHP_EOL;
        $expectedOutput.= 'Email:    '      . $userData['email']    . PHP_EOL;
        $expectedOutput.= 'Username: '   . $userData['username'] . PHP_EOL;

        $this->assertEquals($expectedOutput, $output);
    }
}
