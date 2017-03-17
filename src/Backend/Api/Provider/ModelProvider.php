<?php

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Model\User;

class ModelProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['model.user'] = function () use ($app) {
            return new User(
                $app['repository.user'],
                $app['repository.passwd']
            );
        };
    }

}
