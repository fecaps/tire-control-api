<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;
use Api\Validator\Login as LoginValidator;

class LoginTest extends TestCase
{
    public function testShouldDoLogin()
    {
        $loginData = [
            'email'     => 'test@gmail.com',
            'passwd'    => '12345678'
        ];

        // $mockValidator = $this
        //     ->getMockBuilder('Api\\Validator\\Login')
        //     ->setMethods(['validate'])
        //     ->getMock();

        // $mockValidator
        //     ->expects($this->once())
        //     ->method('validate')
        //     ->with($loginData);

        $validator = new LoginValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->setMethods(['findByEmail'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($loginData['email'])
            ->willReturn(['id' => 1] + $loginData);

        $mockPasswd = $this
            ->getMockBuilder('Api\\Repository\\Passwd')
            ->setMethods(['check'])
            ->getMock();

        $mockPasswd
            ->expects($this->once())
            ->method('check')
            ->with($loginData['passwd'], $loginData['passwd'])
            ->willReturn(true);

        $loginModel = new Login($validator, $mockRepository, $mockPasswd);

        $retrieveData = $loginModel->authenticate($loginData);

        unset($loginData['passwd']);

        $loginData = ['id' => 1] + $loginData;
        
        $this->assertEquals($retrieveData, $loginData);
    }

     /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenUserIsNotFound()
    {
        $loginData = [
            'email'     => 'newTest@gmail.com',
            'passwd'    => '12345678'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Login')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($loginData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->setMethods(['findByEmail'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($loginData['email'])
            ->willReturn(null);

        $mockPasswd = $this
            ->getMockBuilder('Api\\Repository\\Passwd')
            ->getMock();

        $loginModel = new Login($mockValidator, $mockRepository, $mockPasswd);

        $loginModel->authenticate($loginData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenPasswordIsInvalid()
    {
        $loginData = [
            'email'     => 'test@gmail.com',
            'passwd'    => '12345678'
        ];

        $validator = new LoginValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->setMethods(['findByEmail'])
            ->getMock();

        $dbloginData = $loginData;
        $dbloginData['passwd'] = '87654321';

        $mockRepository
            ->expects($this->once())
            ->method('findByEmail')
            ->with($loginData['email'])
            ->willReturn($dbloginData);

        $mockPasswd = $this
            ->getMockBuilder('Api\\Repository\\Passwd')
            ->getMock();

        $mockPasswd
            ->expects($this->once())
            ->method('check')
            ->with($loginData['passwd'], $dbloginData['passwd'])
            ->willReturn(false);

        $loginModel = new Login($validator, $mockRepository, $mockPasswd);

        $loginModel->authenticate($loginData);
    }
}
