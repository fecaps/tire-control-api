<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class BrandTest extends TestCase
{
    public function testShouldCreateABrand()
    {
        $brandData = [
            'name' => 'Brand Test'
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'lastInsertId'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('brand', $brandData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repository = new Brand($mockConnection);

        $retrieveData = $repository->create($brandData);

        $expectedData = ['id' => 2] + $brandData;

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldFindByName()
    {
        $expectedData = [
            'name' => 'Brand Test'
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
            ->with('SELECT * FROM brand WHERE name = ?', [$expectedData['name']])
            ->willReturn($mockQuery);

        $repository = new Brand($mockConnection);

        $retrieveData = $repository->findByName($expectedData['name']);

        $this->assertEquals($expectedData, $retrieveData);
    }

    public function testShouldSelectAll()
    {
        $expectedData = [
            'id'    => '123',
            'name'  => 'Brand Test'
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
            ->with('SELECT * FROM brand')
            ->willReturn($mockQuery);

        $repository = new Brand($mockConnection);

        $retrieveData = $repository->selectAll();

        $this->assertEquals($expectedData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertBrand()
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

        $repository = new Brand($mockConn);

        $repository->create([]);
    }
}
