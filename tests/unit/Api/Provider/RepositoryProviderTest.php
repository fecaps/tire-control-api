<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class RepositoryProviderTest extends TestCase
{
    public function testShouldRegisterControllersProviders()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $mockConnection = $this
            ->getMockBuilder('Doctrine\\DBAL\\Connection')
            ->disableOriginalConstructor()
            ->getMock();

        $mockContainer['db'] = $mockConnection;

        $repositoryProvider = new RepositoryProvider;

        $repositoryProvider->register($mockContainer);
    }
}
