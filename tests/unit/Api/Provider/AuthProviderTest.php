<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class AuthProviderTest extends TestCase
{
    public function testShouldRegisterAuthProviders()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $authProvider = new AuthProvider;

        $authProvider->register($mockContainer);

        $this->assertInstanceOf('Pimple\Container', $mockContainer);

        $this->assertInstanceOf('Api\Provider\AuthProvider', $authProvider);
    }

    public function testShouldCreateAuthMiddleware()
    {
        $mockApplication = $this->createMock('Silex\\Application');

        $authProvider = new AuthProvider;

        $authProvider->boot($mockApplication);

        $this->assertInstanceOf('Silex\Application', $mockApplication);

        $this->assertInstanceOf('Api\Provider\AuthProvider', $authProvider);
    }
}
