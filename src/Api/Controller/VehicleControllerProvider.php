<?php
declare(strict_types=1);

namespace Api\Controller;

use Silex\Application;
use Silex\Api\ControllerProviderInterface;
use Pimple\ServiceProviderInterface;
use Pimple\Container;

class VehicleControllerProvider implements ControllerProviderInterface, ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['vehicle.brandcontroller'] = function () use ($app) {
            return new Vehicle\BrandController($app['model.vehicle.brand']);
        };

        $app['vehicle.categorycontroller'] = function () use ($app) {
            return new Vehicle\CategoryController($app['model.vehicle.category']);
        };

        $app['vehicle.modelcontroller'] = function () use ($app) {
            return new Vehicle\ModelController($app['model.vehicle.model']);
        };

        $app['vehicle.typecontroller'] = function () use ($app) {
            return new Vehicle\TypeController($app['model.vehicle.type']);
        };

        $app['vehiclecontroller'] = function () use ($app) {
            return new VehicleController($app['model.vehicle']);
        };

        $app->mount('/', new $this);
    }

    public function connect(Application $app)
    {
        $controllers = $app['controllers_factory'];

        $controllers->get('/vehicles/brands', 'vehicle.brandcontroller:list');
        $controllers->post('/vehicles/brands', 'vehicle.brandcontroller:create');

        $controllers->get('/vehicles/categories', 'vehicle.categorycontroller:list');
        $controllers->post('/vehicles/categories', 'vehicle.categorycontroller:create');
        
        $controllers->get('/vehicles/models', 'vehicle.modelcontroller:list');
        $controllers->post('/vehicles/models', 'vehicle.modelcontroller:create');

        $controllers->get('/vehicles/types', 'vehicle.typecontroller:list');
        $controllers->post('/vehicles/types', 'vehicle.typecontroller:create');

        $controllers->get('/vehicles', 'vehiclecontroller:list');
        $controllers->post('/vehicles', 'vehiclecontroller:create');

        return $controllers;
    }
}
