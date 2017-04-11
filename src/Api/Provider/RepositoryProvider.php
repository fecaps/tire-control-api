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

        $app['repository.tire'] = function () use ($app) {
            return new Repository\Tire($app['db']);
        };
    }
}
