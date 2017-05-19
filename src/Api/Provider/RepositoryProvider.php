<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Repository;

class RepositoryProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['repository.user'] = function () use ($app) {
            return new Repository\User($app['db']);
        };

        $app['repository.passwd'] = function () {
            return new Repository\Passwd;
        };

        $app['repository.authsession'] = function () use ($app) {
            return new Repository\AuthSession($app['db']);
        };

        $app['repository.tire.brand'] = function () use ($app) {
            return new Repository\Tire\Brand($app['db']);
        };

        $app['repository.tire.model'] = function () use ($app) {
            return new Repository\Tire\Model($app['db']);
        };

        $app['repository.tire.size'] = function () use ($app) {
            return new Repository\Tire\Size($app['db']);
        };

        $app['repository.tire.type'] = function () use ($app) {
            return new Repository\Tire\Type($app['db']);
        };

        $app['repository.tire.tire'] = function () use ($app) {
            return new Repository\Tire\Tire($app['db']);
        };

        $app['repository.vehicle.brand'] = function () use ($app) {
            return new Repository\Vehicle\Brand($app['db']);
        };

        $app['repository.vehicle.category'] = function () use ($app) {
            return new Repository\Vehicle\Category($app['db']);
        };

        $app['repository.vehicle.model'] = function () use ($app) {
            return new Repository\Vehicle\Model($app['db']);
        };

        $app['repository.vehicle.type'] = function () use ($app) {
            return new Repository\Vehicle\Type($app['db']);
        };

        $app['repository.vehicle.vehicle'] = function () use ($app) {
            return new Repository\Vehicle\Vehicle($app['db']);
        };
    }
}
