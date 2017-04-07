<?php
declare(strict_types=1);

namespace Api\Repository\Tire;

use PHPUnit\Framework\TestCase;
use Doctrine\DBAL\DBALException;

class SizeTest extends TestCase
{
    public function testShouldCreateASize()
    {
        $sizeData = [
            'name' => 'Size Test',
        ];

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['insert', 'lastInsertId'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('insert')
            ->with('size', $sizeData)
            ->willReturn(1);

        $mockConnection
            ->expects($this->once())
            ->method('lastInsertId')
            ->willReturn(2);

        $repositorySize = new Size($mockConnection);

        $retrieveSizeData = $repositorySize->create($sizeData);

        $expectedSizeData = $sizeData;

        $this->assertEquals($expectedSizeData, $retrieveSizeData);
    }

    public function testShouldFindByName()
    {
        $expectedSizeData = [
            'name' => 'Size Test',
        ];

        $mockQuery = $this
            ->getMockBuilder('Doctrine\\DBAL\\Statement')
            ->disableOriginalConstructor()
            ->setMethods(['fetch'])
            ->getMock();

        $mockQuery
            ->expects($this->once())
            ->method('fetch')
            ->willReturn($expectedSizeData);

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->setMethods(['executeQuery'])
            ->getMock();

        $mockConnection
            ->expects($this->once())
            ->method('executeQuery')
            ->with('SELECT * FROM size WHERE name = ?', [$expectedSizeData['name']])
            ->willReturn($mockQuery);

        $repositorySize = new Size($mockConnection);

        $retrieveData = $repositorySize->findByName($expectedSizeData['name']);

        $this->assertEquals($expectedSizeData, $retrieveData);
    }

    /**
     * @expectedException Api\Exception\DatabaseException
     */
    public function testShouldGetDatabaseExceptionWhenTryingToInsertSize()
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

        $repository = new Size($mockConn);

        $repository->create([]);
    }
}
