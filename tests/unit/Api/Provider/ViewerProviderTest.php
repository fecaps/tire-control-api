<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class ViewerProviderTest extends TestCase
{
    public function testShouldSetViewReturn()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $mockController = $this
            ->getMockBuilder('Silex\\Controller')
            ->disableOriginalConstructor()
            ->setMethods(['assert'])
            ->getMock();

        $mockController
            ->expects($this->once())
            ->method('assert');

        $mockApplication = $this->createMock('Silex\\Application');
        $mockApplication
            ->expects($this->once())
            ->method('options')
            ->willReturn($mockController);

        $viewerProvider = new ViewerProvider;

        $viewerProvider->register($mockContainer);

        $viewerProvider->boot($mockApplication);
    }
}
