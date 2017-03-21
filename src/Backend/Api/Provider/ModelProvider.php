<?php
declare(strict_types=1);

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Model as Models;

class ModelProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['model.user'] = function () use ($app) {
            return new Models\User(
                $app['validator.user'],
                $app['repository.user'],
                $app['repository.passwd']
            );
        };

        $app['model.login'] = function () use ($app) {
            return new Models\Login(
                $app['validator.login'],
                $app['repository.user'],
                $app['repository.passwd']
            );
        };
    }
}
