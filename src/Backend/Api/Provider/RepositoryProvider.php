<?php

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
    }
}
