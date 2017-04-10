<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;

class TypeTest extends TestCase
{
    public function testShouldCreateNewType()
    {
        $typeData = [
            'name' => 'Type Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Type')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($typeData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($typeData['name'])
            ->willReturn(null);

        $newTypeData = ['id' => 12] + $typeData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($typeData)
            ->willReturn($newTypeData);

        $typeModel = new Type($mockValidator, $mockRepository);

        $retrieveData = $typeModel->create($typeData);

        $this->assertEquals($newTypeData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $typeData = [
            'id'    => '123',
            'name'  => 'Type Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Type')
            ->setMethods(['validate'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['selectAll'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('selectAll')
            ->willReturn($typeData);

        $typeModel = new Type($mockValidator, $mockRepository);

        $retrieveData = $typeModel->selectAll();

        $this->assertEquals($typeData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenNameIsAlreadyInUse()
    {
        $typeData = [
            'name' => 'Type Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Type')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($typeData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($typeData['name'])
            ->willReturn($typeData);

        $typeModel = new Type($mockValidator, $mockRepository);

        $typeModel->create($typeData);
    }
}
