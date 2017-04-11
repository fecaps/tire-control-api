<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;

class BrandTest extends TestCase
{
    public function testShouldCreateNewBrand()
    {
        $brandData = [
            'name' => 'Brand Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Brand')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($brandData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($brandData['name'])
            ->willReturn(null);

         $newBrandData = ['id' => 12] + $brandData;

         $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($brandData)
            ->willReturn($newBrandData);

        $brandModel = new Brand($mockValidator, $mockRepository);

        $retrieveData = $brandModel->create($brandData);

        $this->assertEquals($newBrandData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $brandData = [
            'id'    => '123',
            'name'  => 'Brand Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Brand')
            ->setMethods(['validate'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($brandData);

        $brandModel = new Brand($mockValidator, $mockRepository);

        $retrieveData = $brandModel->list();

        $this->assertEquals($brandData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenNameIsAlreadyInUse()
    {
        $brandData = [
            'name' => 'Brand Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Brand')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($brandData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($brandData['name'])
            ->willReturn($brandData);

        $brandModel = new Brand($mockValidator, $mockRepository);

        $brandModel->create($brandData);
    }
}
