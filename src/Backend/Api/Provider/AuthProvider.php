<?php
declare(strict_types=1);

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Auth\Session;

class AuthProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['auth.session'] = function () use ($app) {
            return new Session($app['model.authsession']);
        };
    }
}
