<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;

class ModelTest extends TestCase
{
    public function testShouldCreateNewModel()
    {
        $modelData = [
            'name' => 'Model Test',
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Model')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($modelData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($modelData['name'])
            ->willReturn(null);

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($modelData)
            ->willReturn($modelData);

        $modelModel = new Model($mockValidator, $mockRepository);

        $retrieveData = $modelModel->create($modelData);

        $this->assertEquals($modelData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenNameIsAlreadyInUse()
    {
        $modelData = [
            'name' => 'Model Test',
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Model')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($modelData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($modelData['name'])
            ->willReturn($modelData);

        $modelModel = new Model($mockValidator, $mockRepository);

        $modelModel->create($modelData);
    }
}
