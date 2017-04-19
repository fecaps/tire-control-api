<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class ErrorProviderTest extends TestCase
{
    public function testShouldSetErrorReturn()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $mockApplication = $this->createMock('Silex\\Application');

        $errorProvider = new ErrorProvider;

        $errorProvider->register($mockContainer);

        $errorProvider->boot($mockApplication);
    
        $this->assertInstanceOf('Pimple\Container', $mockContainer);

        $this->assertInstanceOf('Silex\Application', $mockApplication);
    }
}
