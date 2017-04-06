<?php
declare(strict_types=1);

namespace Api\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class TireControllerProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['tirecontroller'] = function () use ($app) {
            return new TireController($app['model.tire']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/tires/register', 'tirecontroller:register');

        return $controllers;
    }
}
