<?php
declare(strict_types=1);

namespace Api\Model\Vehicle;

use PHPUnit\Framework\TestCase;
use Api\Validator\Vehicle\Vehicle as VehicleValidator;

class VehicleTest extends TestCase
{
    public function testShouldCreateNewVehicle()
    {
        $vehicleData = [
            'brand_id'      => 1,
            'category_id'   => 10,
            'model_id'      => 20,
            'type_id'       => 30,
            'plate'         => 'PLT678'
        ];

        $validator = new VehicleValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['brand_id'])
            ->willReturn(true);

        $mockCategRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockCategRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['category_id'])
            ->willReturn(true);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['model_id'])
            ->willReturn(true);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['type_id'])
            ->willReturn(true);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Vehicle')
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
            'brand_id'      => 1,
            'category_id'   => 10,
            'model_id'      => 20,
            'type_id'       => 30,
            'plate'         => 'PLT678'
        ];

        $validator = new VehicleValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockCategRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Vehicle')
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
            'brand_id'      => 1,
            'category_id'   => 10,
            'model_id'      => 20,
            'type_id'       => 30,
            'plate'         => 'PLT678'
        ];

        $validator = new VehicleValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['brand_id'])
            ->willReturn(false);

        $mockCategRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Category')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockCategRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['category_id'])
            ->willReturn(false);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['model_id'])
            ->willReturn(false);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findById')
            ->with($vehicleData['type_id'])
            ->willReturn(false);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Vehicle\\Vehicle')
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
