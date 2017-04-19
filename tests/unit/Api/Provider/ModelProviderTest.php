<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class ModelProviderTest extends TestCase
{
    public function testShouldRegisterModelProviders()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $mockUserValidator = $this->createMock('Api\\Validator\\User');

        $mockUserRepository = $this
            ->getMockBuilder('Api\\Repository\\User')
            ->disableOriginalConstructor()
            ->getMock();

        $mockPasswdRepository = $this->createMock('Api\\Repository\\Passwd');

        $mockContainer['validator.user'] = $mockUserValidator;
        $mockContainer['repository.user'] = $mockUserRepository;
        $mockContainer['repository.passwd'] = $mockPasswdRepository;

        $modelProvider = new ModelProvider();

        $modelProvider->register($mockContainer);

        $this->assertInstanceOf('Pimple\Container', $mockContainer);
    }
}
