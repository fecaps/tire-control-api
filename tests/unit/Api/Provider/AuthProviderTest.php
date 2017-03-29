<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class AuthProviderTest extends TestCase
{
    public function testShouldRegisterAuthClasses()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $authProvider = new AuthProvider;

        $authProvider->register($mockContainer);
    }

    public function testShouldCreateAuthMiddleware()
    {
        $mockApplication = $this->createMock('Silex\\Application');

        $authProvider = new AuthProvider;

        $authProvider->boot($mockApplication);
    }
}
