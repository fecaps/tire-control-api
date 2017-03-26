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
    }
}
