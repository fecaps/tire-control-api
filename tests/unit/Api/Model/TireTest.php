<?php
declare(strict_types=1);

namespace Api\Model;

use PHPUnit\Framework\TestCase;

class TireTest extends TestCase
{
    public function testShouldCreateNewTire()
    {
        $tireData = [
            'type'          => 'Type Test',
            'brand'         => 'Brand Test',
            'durability'    => 11,
            'cost'          => 180.00,
            'note'          => 'Just a simple note',
            'situation'     => 'Situation Test'
        ];

        $mockValidator = $this
            ->getMockBuilder('Api\\Validator\\Tire')
            ->setMethods(['validate'])
            ->getMock();

        $mockValidator
            ->expects($this->once())
            ->method('validate')
            ->with($tireData);

        $mockRepository = $this
            ->getMockBuilder('Api\\Repository\\Tire')
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $newTireData = ['id' => 123] + $tireData;

        $mockRepository
            ->expects($this->once())
            ->method('create')
            ->with($tireData)
            ->willReturn($newTireData);

        $tireModel = new Tire($mockValidator, $mockRepository);

        $retrieveData = $tireModel->create($tireData);

        $this->assertEquals($newTireData, $retrieveData);
    }
}
