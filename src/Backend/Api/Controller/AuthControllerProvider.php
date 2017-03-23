<?php
declare(strict_types=1);

namespace Backend\Api\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class AuthControllerProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['controller.auth'] = function () use ($app) {
            return new AuthController($app['model.login'], $app['auth.session']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/login', 'controller.auth:login');

        return $controllers;
    }
}