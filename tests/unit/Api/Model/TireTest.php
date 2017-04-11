<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;

class TireTest extends TestCase
{
    public function testShouldCreateNewTire()
    {
        $tireData = [
            'brand' => 'Brand Test',
            'model' => 'Model Test',
            'size'  => 'Size Test',
            'type'  => 'Type Test',
            'dot'   => 'DOT Test',
            'code'  => 'Code Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($tireData);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['brand'])
            ->willReturn(true);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['model'])
            ->willReturn(true);

        $mockSizeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockSizeRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['size'])
            ->willReturn(true);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['type'])
            ->willReturn(true);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire')
            ->disableOriginalConstructor()
            ->setMethods(['findByCode', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($tireData['code'])
            ->willReturn(null);

        $newTireData = ['id' => 123] + $tireData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($tireData)
            ->willReturn($newTireData);

        $tireModel = new Tire(
            $mockValidator,
            $mockBrandRepository,
            $mockModelRepository,
            $mockSizeRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $retrieveData = $tireModel->create($tireData);

        $this->assertEquals($newTireData, $retrieveData);
    }

    
     /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenDataAlreadyInUse()
    {
        $tireData = [
            'brand' => 'Brand Test',
            'model' => 'Model Test',
            'size'  => 'Size Test',
            'type'  => 'Type Test',
            'dot'   => 'DOT Test',
            'code'  => 'Code Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($tireData);

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['brand'])
            ->willReturn(false);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['model'])
            ->willReturn(false);

        $mockSizeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockSizeRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['size'])
            ->willReturn(false);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($tireData['type'])
            ->willReturn(false);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire')
            ->disableOriginalConstructor()
            ->setMethods(['findByCode', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($tireData['code'])
            ->willReturn($tireData);

        $tireModel = new Tire(
            $mockValidator,
            $mockBrandRepository,
            $mockModelRepository,
            $mockSizeRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $tireModel->create($tireData);
    }

    public function testShouldSelectAll()
    {
        $tireData = [
            'brand' => 'Brand Test',
            'model' => 'Model Test',
            'size'  => 'Size Test',
            'type'  => 'Type Test',
            'dot'   => 'DOT Test',
            'code'  => 'Code Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire')
            ->setMethods(['validate'])
            ->getMock();

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockSizeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($tireData);

        $tireModel = new Tire(
            $mockValidator,
            $mockBrandRepository,
            $mockModelRepository,
            $mockSizeRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $retrieveData = $tireModel->list();

        $this->assertEquals($tireData, $retrieveData);
    }
}
