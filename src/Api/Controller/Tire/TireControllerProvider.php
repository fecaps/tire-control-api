<?php
declare(strict_types=1);

namespace Api\Controller\Tire;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class TireControllerProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['tire-brandcontroller'] = function () use ($app) {
            return new BrandController($app['model.tire.brand']);
        };

        $app['tire-modelcontroller'] = function () use ($app) {
            return new ModelController($app['model.tire.model']);
        };

        $app['tire-sizecontroller'] = function () use ($app) {
            return new SizeController($app['model.tire.size']);
        };

        $app['tire-typecontroller'] = function () use ($app) {
            return new TypeController($app['model.tire.type']);
        };

        $app['tirecontroller'] = function () use ($app) {
            return new TireController($app['model.tire.tire']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/tires/brands', 'tire-brandcontroller:list');
        $controllers->post('/tires/brands', 'tire-brandcontroller:create');

        $controllers->get('/tires/models', 'tire-modelcontroller:list');
        $controllers->post('/tires/models', 'tire-modelcontroller:create');
        
        $controllers->get('/tires/sizes', 'tire-sizecontroller:list');
        $controllers->post('/tires/sizes', 'tire-sizecontroller:create');
        
        $controllers->get('/tires/types', 'tire-typecontroller:list');
        $controllers->post('/tires/types', 'tire-typecontroller:create');

        $controllers->get('/tires', 'tirecontroller:list');
        $controllers->post('/tires', 'tirecontroller:create');

        return $controllers;
    }
}
