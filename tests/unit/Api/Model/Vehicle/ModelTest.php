<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Validator\Vehicle\Model as ModelValidator;

class ModelTest extends TestCase
{
    public function testShouldCreateNewModel()
    {
        $modelData = [
            'brand' => 'Brand Test',
            'model' => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByModel', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByModel')
            ->with($modelData['model'])
            ->willReturn(null);

        $newModelData = ['id' => 12] + $modelData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($modelData)
            ->willReturn($newModelData);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($modelData['brand'])
            ->willReturn(true);

        $modelModel = new Model($validator, $mockRepository, $mockBrandRepository);

        $retrieveData = $modelModel->create($modelData);

        $this->assertEquals($newModelData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $modelData = [
            'id'    => '123',
            'brand' => 'Brand Test',
            'model' => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($modelData);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->getMock();

        $modelModel = new Model($validator, $mockRepository, $mockBrandRepository);

        $retrieveData = $modelModel->list();

        $this->assertEquals($modelData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenBrandAndModelAreAlreadyInUse()
    {
        $modelData = [
            'brand' => 'Brand Test',
            'model' => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByModel'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByModel')
            ->with($modelData['model'])
            ->willReturn($modelData);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($modelData['brand'])
            ->willReturn(false);

        $modelModel = new Model($validator, $mockRepository, $mockBrandRepository);

        $modelModel->create($modelData);
    }
}
