<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;
use Api\Validator\Tire\Model as ModelValidator;

class ModelTest extends TestCase
{
    public function testShouldCreateNewModel()
    {
        $modelData = [
            'name' => 'Model Test'
        ];

        $validator = new ModelValidator;

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

        $newModelData = ['id' => 12] + $modelData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($modelData)
            ->willReturn($newModelData);

        $modelModel = new Model($validator, $mockRepository);

        $retrieveData = $modelModel->create($modelData);

        $this->assertEquals($newModelData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $modelData = [
            'id'    => '123',
            'name'  => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($modelData);

        $modelModel = new Model($validator, $mockRepository);

        $retrieveData = $modelModel->list();

        $this->assertEquals($modelData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenNameIsAlreadyInUse()
    {
        $modelData = [
            'name' => 'Model Test'
        ];

        $validator = new ModelValidator;

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

        $modelModel = new Model($validator, $mockRepository);

        $modelModel->create($modelData);
    }
}
