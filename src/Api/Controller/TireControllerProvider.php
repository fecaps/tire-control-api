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
        $app['tire.brandcontroller'] = function () use ($app) {
            return new Tire\BrandController($app['model.tire.brand']);
        };

        $app['tire.modelcontroller'] = function () use ($app) {
            return new Tire\ModelController($app['model.tire.model']);
        };

        $app['tire.sizecontroller'] = function () use ($app) {
            return new Tire\SizeController($app['model.tire.size']);
        };

        $app['tire.typecontroller'] = function () use ($app) {
            return new Tire\TypeController($app['model.tire.type']);
        };

        $app['tirecontroller'] = function () use ($app) {
            return new TireController($app['model.tire']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/tires/brands', 'tire.brandcontroller:selectAll');
        $controllers->post('/tires/brands', 'tire.brandcontroller:register');

        $controllers->get('/tires/models', 'tire.modelcontroller:selectAll');
        $controllers->post('/tires/models', 'tire.modelcontroller:register');
        
        $controllers->get('/tires/sizes', 'tire.sizecontroller:selectAll');
        $controllers->post('/tires/sizes', 'tire.sizecontroller:register');
        
        $controllers->get('/tires/types', 'tire.typecontroller:selectAll');
        $controllers->post('/tires/types', 'tire.typecontroller:register');

        $controllers->get('/tires', 'tirecontroller:selectAll');
        $controllers->post('/tires', 'tirecontroller:register');

        return $controllers;
    }
}
