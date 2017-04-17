<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;

class VehicleTest extends TestCase
{
    public function testShouldCreateNewVehicle()
    {
        $vehicleData = [
            'type'      => 'Type Test',
            'brand'     => 'Brand Test',
            'model'     => 'Model Test',
            'category'  => 'Category Test',
            'plate'     => 'Plate Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Vehicle')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($vehicleData);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['type'])
            ->willReturn(true);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['brand'])
            ->willReturn(true);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['model'])
            ->willReturn(true);

        $mockCategoryRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockCategoryRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['category'])
            ->willReturn(true);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle')
            ->disableOriginalConstructor()
            ->setMethods(['findByPlate', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByPlate')
            ->with($vehicleData['plate'])
            ->willReturn(null);

        $newVehicleData = ['id' => 123] + $vehicleData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($vehicleData)
            ->willReturn($newVehicleData);

        $vehicleModel = new Vehicle(
            $mockValidator,
            $mockTypeRepository,
            $mockBrandRepository,
            $mockModelRepository,
            $mockCategoryRepository,
            $mockRepository
        );

        $retrieveData = $vehicleModel->create($vehicleData);

        $this->assertEquals($newVehicleData, $retrieveData);
    }

    
     /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenDataAlreadyInUse()
    {
        $vehicleData = [
            'type'      => 'Type Test',
            'brand'     => 'Brand Test',
            'model'     => 'Model Test',
            'category'  => 'Category Test',
            'plate'     => 'Plate Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Vehicle')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($vehicleData);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['type'])
            ->willReturn(false);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['brand'])
            ->willReturn(false);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['model'])
            ->willReturn(false);

        $mockCategoryRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockCategoryRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['category'])
            ->willReturn(false);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle')
            ->disableOriginalConstructor()
            ->setMethods(['findByPlate', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByPlate')
            ->with($vehicleData['plate'])
            ->willReturn($vehicleData);

        $vehicleModel = new Vehicle(
            $mockValidator,
            $mockTypeRepository,
            $mockBrandRepository,
            $mockModelRepository,
            $mockCategoryRepository,
            $mockRepository
        );

        $vehicleModel->create($vehicleData);
    }

    public function testShouldSelectAll()
    {
        $vehicleData = [
            'type'      => 'Type Test',
            'brand'     => 'Brand Test',
            'model'     => 'Model Test',
            'category'  => 'Category Test',
            'plate'     => 'Plate Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Vehicle')
            ->setMethods(['validate'])
            ->getMock();

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockCategoryRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($vehicleData);

        $vehicleModel = new Vehicle(
            $mockValidator,
            $mockTypeRepository,
            $mockBrandRepository,
            $mockModelRepository,
            $mockCategoryRepository,
            $mockRepository
        );

        $retrieveData = $vehicleModel->list();

        $this->assertEquals($vehicleData, $retrieveData);
    }
}
