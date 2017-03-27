<?php
declare(strict_types=1);

namespace Api\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class AuthControllerProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['authcontroller'] = function () use ($app) {
            return new AuthController($app['model.login'], $app['auth.session']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/login', 'authcontroller:login');
        $controllers->put('/logout', 'authcontroller:logout');

        return $controllers;
    }
}
