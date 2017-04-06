<?php
declare(strict_types=1);

namespace Api\Repository;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class TireTest extends TestCase
{
    public function testShouldCreateATire()
    {
        $tireData = [
            'type'          => 'Type Test',
            'brand'         => 'Brand Test',
            'durability'    => 11,
            'cost'          => 180.00,
            'note'          => 'Just a simple note',
            'situation'     => 'Situation Test'
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'lastInsertId'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('tire', $tireData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repositoryTire = new Tire($mockConnection);

        $retrieveTireData = $repositoryTire->create($tireData);

        $expectedTireData = ['id' => 2] + $tireData;

        $this->assertEquals($expectedTireData, $retrieveTireData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertSession()
    {
        $mockConn = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert'])
            ->getMock();

        $mockConn
            ->expects($this->once())
            ->method('insert')
            ->will($this->throwException(new DBALException('An error has ocurred')));

        $repository = new Tire($mockConn);

        $repository->create([]);
    }
}
