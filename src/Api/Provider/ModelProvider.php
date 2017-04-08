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

        $app['model.tire.brand'] = function () use ($app) {
            return new Model\Tire\Brand(
                $app['validator.tire.brand'],
                $app['repository.tire.brand']
            );
        };

        $app['model.tire.model'] = function () use ($app) {
            return new Model\Tire\Model(
                $app['validator.tire.model'],
                $app['repository.tire.model']
            );
        };

        $app['model.tire.size'] = function () use ($app) {
            return new Model\Tire\Size(
                $app['validator.tire.size'],
                $app['repository.tire.size']
            );
        };

        $app['model.tire.type'] = function () use ($app) {
            return new Model\Tire\Type(
                $app['validator.tire.type'],
                $app['repository.tire.type']
            );
        };
    }
}
