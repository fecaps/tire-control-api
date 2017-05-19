<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class TireTest extends TestCase
{
    public function testShouldFindByCode()
    {
        $expectedData = [
            'brand_id'          => 1,
            'model_id'          => 10,
            'size_id'           => 20,
            'type_id'           => 30,
            'dot'               => '4444',
            'code'              => '666666',
            'purchase_date'     => '2017-12-31',
            'purchase_price'    => '17.50'
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetch'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetch')
            ->willReturn($expectedData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM tire WHERE code = ?', [$expectedData['code']])
            ->willReturn($mockQuery);

        $repository = new Tire($mockConnection);

        $retrieveData = $repository->findByCode($expectedData['code']);

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldCreateATire()
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

        $repository = new Tire($mockConnection);

        $retrieveData = $repository->create($tireData);

        $expectedData = ['id' => 2] + $tireData;

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $expectedData = [
            'brand_id'          => 1,
            'model_id'          => 10,
            'size_id'           => 20,
            'type_id'           => 30,
            'dot'               => '4444',
            'code'              => '666666',
            'purchase_date'     => '2017-12-31',
            'purchase_price'    => '17.50'
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetchAll'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetchAll')
            ->willReturn($expectedData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM tire')
            ->willReturn($mockQuery);

        $repository = new Tire($mockConnection);

        $retrieveData = $repository->list();

        $this->assertEquals($expectedData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertTire()
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
