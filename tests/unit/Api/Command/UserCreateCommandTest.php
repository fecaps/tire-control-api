<?php
declare(strict_types=1);

namespace Api\Command;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Tester\CommandTester;
use Api\Exception\ValidatorException;

class UserCreateCommandTest extends TestCase
{
    public function testShouldCreateNewUser()
    {
        $userData = [
            'name'      => 'Name Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'passwd'    => '12345678'
        ];

        $mockModel = $this
            ->getMockBuilder('Api\\Model\\User')
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
        $expectedOutput.= 'ID:       1' . PHP_EOL;
        $expectedOutput.= 'Name:     ' . $userData['name']     . PHP_EOL;
        $expectedOutput.= 'Email:    ' . $userData['email']    . PHP_EOL;
        $expectedOutput.= 'Username: ' . $userData['username'] . PHP_EOL;

        $this->assertEquals($expectedOutput, $output);
    }

    /**
    * @expectedException Exception
    **/
    public function testShouldThrowValidatorErrorOnInvalidUserData()
    {
        $userData = [
            'name'      => 'Name Test',
            'email'     => 'test@gmail.com',
            'username'  => 'usernameTest',
            'passwd'    => '12345'
        ];

        $mockModel = $this
            ->getMockBuilder('Api\\Model\\User')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $mockModel
            ->expects($this->once())
            ->method('create')
            ->with($userData)
            ->will($this->throwException(new ValidatorException('An error has ocorred.')));

        $command = new UserCreateCommand;
        $command->setModel($mockModel);

        $commandTester = new CommandTester($command);

        $commandTester->execute($userData);
    }
}
