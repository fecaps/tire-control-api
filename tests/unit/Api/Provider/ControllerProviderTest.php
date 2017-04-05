<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class ControllerProviderTest extends TestCase
{
    public function testShouldRegisterControllerProviders()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $mockContainer
            ->expects($this->any())
            ->method('register');

        $controllerProvider = new ControllerProvider;

        $controllerProvider->register($mockContainer);
    }
}
