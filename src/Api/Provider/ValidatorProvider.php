<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Validator;

class ValidatorProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['validator.user'] = function () {
            return new Validator\User;
        };

        $app['validator.login'] = function () {
            return new Validator\Login;
        };

        $app['validator.authsession'] = function () {
            return new Validator\AuthSession;
        };

        $app['validator.tire.brand'] = function () {
            return new Validator\Tire\Brand;
        };

        $app['validator.tire.model'] = function () {
            return new Validator\Tire\Model;
        };
        
        $app['validator.tire.size'] = function () {
            return new Validator\Tire\Size;
        };

        $app['validator.tire.type'] = function () {
            return new Validator\Tire\Type;
        };

        $app['validator.tire'] = function () {
            return new Validator\Tire;
        };

        $app['validator.vehicle.brand'] = function () {
            return new Validator\Vehicle\Brand;
        };

        $app['validator.vehicle.category'] = function () {
            return new Validator\Vehicle\Category;
        };

        $app['validator.vehicle.type'] = function () {
            return new Validator\Vehicle\Type;
        };

        $app['validator.vehicle'] = function () {
            return new Validator\Vehicle;
        };
    }
}
