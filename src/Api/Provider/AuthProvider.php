<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Api\Auth\Session;
use Exception;

class AuthProvider implements ServiceProviderInterface, BootableProviderInterface
{
    public function register(Container $app)
    {
        $app['auth.session'] = function () use ($app) {
            return new Session($app['model.authsession']);
        };
    }

    public function boot(Application $app)
    {
        $app->before(function (Request $request, Application $app) {
            $controllerName = $request->attributes->get('_controller');

            if ($controllerName != 'authcontroller.login') {
                $token = $request->headers->get('webapi-token');
                
                if (!$token) {
                    throw new Exception('Token is missing on request headers.');
                }

                $check = $app['model.authsession']->check($token);

                if (!$check) {
                    throw new Exception('Token not found or expired.');
                }
            }
        });
    }
}
