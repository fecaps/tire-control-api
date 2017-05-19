<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;
use Api\Validator\Tire\Tire as TireValidator;

class TireTest extends TestCase
{
    public function testShouldCreateNewTire()
    {
        $tireData = [
            'brand_id'          => 1,
            'model_id'          => 10,
            'size_id'           => 20,
            'type_id'           => 30,
            'dot'               => '4444',
            'code'              => '666666',
            'purchase_date'     => '2017-12-31',
            'purchase_price'    => '17.50'
        ];

        $validator = new TireValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['brand_id'])
            ->willReturn(true);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['model_id'])
            ->willReturn(true);

        $mockSizeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockSizeRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['size_id'])
            ->willReturn(true);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['type_id'])
            ->willReturn(true);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Tire')
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
            $validator,
            $mockBrandRepository,
            $mockModelRepository,
            $mockSizeRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $retrieveData = $tireModel->create($tireData);

        $this->assertEquals($newTireData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $tireData = [
            'brand_id'          => 1,
            'model_id'          => 10,
            'size_id'           => 20,
            'type_id'           => 30,
            'dot'               => '4444',
            'code'              => '666666',
            'purchase_date'     => '2017-12-31',
            'purchase_price'    => '17.50'
        ];

        $validator = new TireValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockSizeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Tire')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($tireData);

        $tireModel = new Tire(
            $validator,
            $mockBrandRepository,
            $mockModelRepository,
            $mockSizeRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $retrieveData = $tireModel->list();

        $this->assertEquals($tireData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenDataAlreadyInUse()
    {
        $tireData = [
            'brand_id'          => 1,
            'model_id'          => 10,
            'size_id'           => 20,
            'type_id'           => 30,
            'dot'               => '4444',
            'code'              => '666666',
            'purchase_date'     => '2017-12-31',
            'purchase_price'    => '17.50'
        ];

        $validator = new TireValidator;

        $mockBrandRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Brand')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockBrandRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['brand_id'])
            ->willReturn(false);

        $mockModelRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Model')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockModelRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['model_id'])
            ->willReturn(false);

        $mockSizeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockSizeRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['size_id'])
            ->willReturn(false);

        $mockTypeRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Type')
            ->disableOriginalConstructor()
            ->setMethods(['findById'])
            ->getMock();

        $mockTypeRepository
            ->expects($this->once())
            ->method('findById')
            ->with($tireData['type_id'])
            ->willReturn(false);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Tire')
            ->disableOriginalConstructor()
            ->setMethods(['findByCode', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByCode')
            ->with($tireData['code'])
            ->willReturn($tireData);

        $tireModel = new Tire(
            $validator,
            $mockBrandRepository,
            $mockModelRepository,
            $mockSizeRepository,
            $mockTypeRepository,
            $mockRepository
        );

        $tireModel->create($tireData);
    }
}
