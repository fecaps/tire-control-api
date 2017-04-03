<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Silex\Controller;
use Silex\ControllerCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ViewerProvider implements ServiceProviderInterface, BootableProviderInterface
{
    private $container;

    public function register(Container $container)
    {
        $this->container = $container;
    }

    public function boot(Application $app)
    {
        $app->view(function (array $data, Request $request) use ($app) {
            $code = 200;

            if ($request->getMethod() == 'POST') {
                $code = 201;
            }
    
            if ($request->getMethod() == 'PUT') {
                $code = 204;
            }
        
            return $app->json($data, $code);
        });

        $app->after(function (Request $request, Response $response) {
            $allowedHeaders = 'Date, Server, X-Powered-By, Accept, Accept-Version,' .
            'Content-Length, Content-Type, Origin, token';

            $response->headers->set('Access-Control-Allow-Origin', '*');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, OPTIONS');
            $response->headers->set('Access-Control-Allow-Headers', $allowedHeaders);
        });

        $app->options('{wildcard}', function (Request $request) {
            return [];
        })
        ->assert('wildcard', '.*');
    }
}
