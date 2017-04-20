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

        $app['model.tire'] = function () use ($app) {
            return new Model\Tire(
                $app['validator.tire'],
                $app['repository.tire.brand'],
                $app['repository.tire.model'],
                $app['repository.tire.size'],
                $app['repository.tire.type'],
                $app['repository.tire']
            );
        };

        $app['model.vehicle.brand'] = function () use ($app) {
            return new Model\Vehicle\Brand(
                $app['validator.vehicle.brand'],
                $app['repository.vehicle.brand']
            );
        };

        $app['model.vehicle.category'] = function () use ($app) {
            return new Model\Vehicle\Category(
                $app['validator.vehicle.category'],
                $app['repository.vehicle.category']
            );
        };

        $app['model.vehicle.model'] = function () use ($app) {
            return new Model\Vehicle\Model(
                $app['validator.vehicle.model'],
                $app['repository.vehicle.model'],
                $app['repository.vehicle.brand']
            );
        };

        $app['model.vehicle.type'] = function () use ($app) {
            return new Model\Vehicle\Type(
                $app['validator.vehicle.type'],
                $app['repository.vehicle.type']
            );
        };

        $app['model.vehicle'] = function () use ($app) {
            return new Model\Vehicle(
                $app['validator.vehicle'],
                $app['repository.vehicle.brand'],
                $app['repository.vehicle.category'],
                $app['repository.vehicle.type'],
                $app['repository.vehicle']
            );
        };
    }
}
