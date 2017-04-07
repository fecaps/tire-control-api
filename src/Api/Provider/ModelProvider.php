<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Model;

class ModelProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['model.user'] = function () use ($app) {
            return new Model\User(
                $app['validator.user'],
                $app['repository.user'],
                $app['repository.passwd']
            );
        };

        $app['model.login'] = function () use ($app) {
            return new Model\Login(
                $app['validator.login'],
                $app['repository.user'],
                $app['repository.passwd']
            );
        };

        $app['model.authsession'] = function () use ($app) {
            return new Model\AuthSession(
                $app['validator.authsession'],
                $app['repository.authsession']
            );
        };

        $app['model.tire.size'] = function () use ($app) {
            return new Model\Tire\Size(
                $app['validator.tire.size'],
                $app['repository.tire.size']
            );
        };
    }
}
