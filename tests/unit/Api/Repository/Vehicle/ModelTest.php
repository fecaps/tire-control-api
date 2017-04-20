<?php
declare(strict_types=1);

namespace Api\Repository\Vehicle;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class ModelTest extends TestCase
{
    public function testShouldCreateAType()
    {
        $modelData = [
            'brand' => 'Brand Test',
            'model' => 'Model Test'
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'lastInsertId'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('vehicle_model_brand', $modelData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repository = new Model($mockConnection);

        $retrieveData = $repository->create($modelData);

        $expectedData = ['id' => 2] + $modelData;

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldFindByModel()
    {
        $expectedData = [
            'model' => 'Model Test'
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
            ->with('SELECT * FROM vehicle_model_brand WHERE model = ?', [$expectedData['model']])
            ->willReturn($mockQuery);

        $repository = new Model($mockConnection);

        $retrieveData = $repository->findByModel($expectedData['model']);

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $expectedData = [
            'id'    => '123',
            'brand' => 'Brand Test',
            'model' => 'Model Test'
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
            ->with('SELECT * FROM vehicle_model_brand')
            ->willReturn($mockQuery);

        $repository = new Model($mockConnection);

        $retrieveData = $repository->list();

        $this->assertEquals($expectedData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertModel()
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

        $repository = new Model($mockConn);

        $repository->create([]);
    }
}
