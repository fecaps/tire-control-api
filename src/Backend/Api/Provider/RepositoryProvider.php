<?php
declare(strict_types=1);

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Repository;

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
    }
}
