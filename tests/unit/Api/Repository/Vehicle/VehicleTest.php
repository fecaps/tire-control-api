<?php
declare(strict_types=1);

namespace Api\Repository\Vehicle;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class VehicleTest extends TestCase
{
    public function testShouldFindByPlate()
    {
        $expectedData = [
            'brand_id'      => 1,
            'category_id'   => 10,
            'model_id'      => 20,
            'type_id'       => 30,
            'plate'         => 'PLT678'
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
            ->with('SELECT * FROM vehicle WHERE plate = ?', [$expectedData['plate']])
            ->willReturn($mockQuery);

        $repository = new Vehicle($mockConnection);

        $retrieveData = $repository->findByPlate($expectedData['plate']);

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldCreateAVehicle()
    {
        $vehicleData = [
            'brand_id'      => 1,
            'category_id'   => 10,
            'model_id'      => 20,
            'type_id'       => 30,
            'plate'         => 'PLT678'
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'lastInsertId'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('vehicle', $vehicleData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repository = new Vehicle($mockConnection);

        $retrieveData = $repository->create($vehicleData);

        $expectedData = ['id' => 2] + $vehicleData;

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $expectedData = [
            'brand_id'      => 1,
            'category_id'   => 10,
            'model_id'      => 20,
            'type_id'       => 30,
            'plate'         => 'PLT678'
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
            ->with('
            SELECT a.id, b.name as brand, c.name as category,
            d.model as model, e.name as type, a.plate FROM vehicle a 
            LEFT JOIN vehicle_brand b ON a.brand_id = b.id 
            LEFT JOIN vehicle_category c ON a.category_id = c.id
            LEFT JOIN vehicle_model_brand d ON a.model_id = d.id
            LEFT JOIN vehicle_type e ON a.type_id = e.id')
            ->willReturn($mockQuery);

        $repository = new Vehicle($mockConnection);

        $retrieveData = $repository->list();

        $this->assertEquals($expectedData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertVehicle()
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

        $repository = new Vehicle($mockConn);

        $repository->create([]);
    }
}
