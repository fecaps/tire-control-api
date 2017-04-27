<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;
use Api\Validator\Vehicle as VehicleValidator;

class VehicleTest extends TestCase
{
    public function testShouldCreateNewVehicle()
    {
        $vehicleData = [
            'type'      => 'Type Test',
            'brand'     => 'Brand Test',
            'model'     => 'Model Test',
            'category'  => 'Category Test',
            'plate'     => 'PLT678'
        ];

        $validator = new VehicleValidator;

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

        $mockCategRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockCategRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['category'])
            ->willReturn(true);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByModel'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findByModel')
            ->with($vehicleData['model'])
            ->willReturn(true);

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
            $validator,
            $mockBrandRepository,
            $mockCategRepository,
            $mockModelRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $retrieveData = $vehicleModel->create($vehicleData);

        $this->assertEquals($newVehicleData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $vehicleData = [
            'type'      => 'Type Test',
            'brand'     => 'Brand Test',
            'model'     => 'Model Test',
            'category'  => 'Category Test',
            'plate'     => 'PLT678'
        ];

        $validator = new VehicleValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockCategRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByModel'])
            ->getMock();

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
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
            $validator,
            $mockBrandRepository,
            $mockCategRepository,
            $mockModelRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $retrieveData = $vehicleModel->list();

        $this->assertEquals($vehicleData, $retrieveData);
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
            'plate'     => 'PLT678'
        ];

        $validator = new VehicleValidator;

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

        $mockCategRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockCategRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($vehicleData['category'])
            ->willReturn(false);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByModel'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findByModel')
            ->with($vehicleData['model'])
            ->willReturn(false);

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
            $validator,
            $mockBrandRepository,
            $mockCategRepository,
            $mockModelRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $vehicleModel->create($vehicleData);
    }
}
