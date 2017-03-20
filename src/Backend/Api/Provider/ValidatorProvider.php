<?php

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Validator\User;

class ValidatorProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['validator.user'] = function () {
            return new User;
        };
    }
}
