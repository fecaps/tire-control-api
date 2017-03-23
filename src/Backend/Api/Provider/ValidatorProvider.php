<?php
declare(strict_types=1);

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Validator as Validators;

class ValidatorProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['validator.user'] = function () {
            return new Validators\User;
        };

        $app['validator.login'] = function () {
            return new Validators\Login;
        };
    }
}
