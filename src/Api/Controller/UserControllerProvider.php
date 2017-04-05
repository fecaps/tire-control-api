<?php
declare(strict_types=1);

namespace Api\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class UserControllerProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['usercontroller'] = function () use ($app) {
            return new UserController($app['model.user']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/signup', 'usercontroller:signup');

        return $controllers;
    }
}
