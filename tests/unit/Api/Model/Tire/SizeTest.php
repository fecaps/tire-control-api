<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;

class SizeTest extends TestCase
{
    public function testShouldCreateNewSize()
    {
        $sizeData = [
            'name' => 'Size Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Size')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($sizeData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findByName', 'create'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($sizeData['name'])
            ->willReturn(null);

        $newSizeData = ['id' => 12] + $sizeData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($sizeData)
            ->willReturn($newSizeData);

        $sizeModel = new Size($mockValidator, $mockRepository);

        $retrieveData = $sizeModel->create($sizeData);

        $this->assertEquals($newSizeData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $sizeData = [
            'id'    => '123',
            'name'  => 'Size Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Size')
            ->setMethods(['validate'])
            ->getMock();

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['selectAll'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('selectAll')
            ->willReturn($sizeData);

        $sizeModel = new Size($mockValidator, $mockRepository);

        $retrieveData = $sizeModel->selectAll();

        $this->assertEquals($sizeData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\ValidatorException
     */
    public function testShouldGetErrorWhenNameIsAlreadyInUse()
    {
        $sizeData = [
            'name' => 'Size Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire\\Size')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($sizeData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['findByName'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('findByName')
            ->with($sizeData['name'])
            ->willReturn($sizeData);

        $sizeModel = new Size($mockValidator, $mockRepository);

        $sizeModel->create($sizeData);
    }
}
