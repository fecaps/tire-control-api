<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Validator\Vehicle\Type as TypeValidator;

class TypeTest extends TestCase
{
    public function testShouldCreateNewType()
    {
        $typeData = [
            'name' => 'Type Test'
        ];

        $validator = new TypeValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
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

        $typeModel = new Type($validator, $mockRepository);

        $retrieveData = $typeModel->create($typeData);

        $this->assertEquals($newTypeData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $typeData = [
            'id'    => '123',
            'name'  => 'Type Test'
        ];

        $validator = new TypeValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($typeData);

        $typeModel = new Type($validator, $mockRepository);

        $retrieveData = $typeModel->list();

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

        $validator = new TypeValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($typeData['name'])
            ->willReturn($typeData);

        $typeModel = new Type($validator, $mockRepository);

        $typeModel->create($typeData);
    }
}
