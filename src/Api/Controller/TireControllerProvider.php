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
        $app['tire.sizecontroller'] = function () use ($app) {
            return new Tire\SizeController($app['model.tire.size']);
        };

        $app['tire.brandcontroller'] = function () use ($app) {
            return new Tire\BrandController($app['model.tire.brand']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->post('/tires/brand', 'tire.brandcontroller:register');
        $controllers->post('/tires/size', 'tire.sizecontroller:register');

        return $controllers;
    }
}
