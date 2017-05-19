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
            'brand_id'  => 1,
            'model'     => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findById')
            ->with($modelData['brand_id'])
            ->willReturn(true);

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

        $modelModel = new Model($validator, $mockBrandRepository, $mockRepository);

        $retrieveData = $modelModel->create($modelData);

        $this->assertEquals($newModelData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $modelData = [
            'id'        => 123,
            'brand_id'  => 1,
            'model'     => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($modelData);

        $modelModel = new Model($validator, $mockBrandRepository, $mockRepository);

        $retrieveData = $modelModel->list();

        $this->assertEquals($modelData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenBrandAndModelAreAlreadyInUse()
    {
        $modelData = [
            'brand_id'  => 1,
            'model'     => 'Model Test'
        ];

        $validator = new ModelValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findById')
            ->with($modelData['brand_id'])
            ->willReturn(false);

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

        $modelModel = new Model($validator, $mockBrandRepository, $mockRepository);

        $modelModel->create($modelData);
    }
}
