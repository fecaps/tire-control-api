<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Validator;

class ValidatorProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['validator.user'] = function () {
            return new Validator\User;
        };

        $app['validator.login'] = function () {
            return new Validator\Login;
        };

        $app['validator.authsession'] = function () {
            return new Validator\AuthSession;
        };

        $app['validator.tire'] = function () {
            return new Validator\Tire;
        };
    }
}
