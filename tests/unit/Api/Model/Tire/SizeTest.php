<?php
declare(strict_types=1);

namespace Api\Model\Tire;

use PHPUnit\Framework\TestCase;
use Api\Validator\Tire\Size as SizeValidator;

class SizeTest extends TestCase
{
    public function testShouldCreateNewSize()
    {
        $sizeData = [
            'name' => 'Size Test'
        ];

        $validator = new SizeValidator;

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

        $sizeModel = new Size($validator, $mockRepository);

        $retrieveData = $sizeModel->create($sizeData);

        $this->assertEquals($newSizeData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $sizeData = [
            'id'    => '123',
            'name'  => 'Size Test'
        ];

        $validator = new SizeValidator;

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire\\Size')
            ->disableOriginalConstructor()
            ->setMethods(['list'])
            ->getMock();

        $mockRepository
            ->expects($this->once())
            ->method('list')
            ->willReturn($sizeData);

        $sizeModel = new Size($validator, $mockRepository);

        $retrieveData = $sizeModel->list();

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

        $validator = new SizeValidator;

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

        $sizeModel = new Size($validator, $mockRepository);

        $sizeModel->create($sizeData);
    }
}
