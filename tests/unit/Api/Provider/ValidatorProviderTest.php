<?php
declare(strict_types=1);

namespace Api\Provider;

use PHPUnit\Framework\TestCase;

class ValidatorProviderTest extends TestCase
{
    public function testShouldRegisterValidatorProviders()
    {
        $mockContainer = $this->createMock('Pimple\\Container');

        $validatorProvider = new ValidatorProvider;

        $validatorProvider->register($mockContainer);
    }
}
