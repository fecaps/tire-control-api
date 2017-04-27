<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
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
        $app->before(function (Request $request) {
            $contentType = $request->headers->get('Content-Type') ?? 'Content-Type';
            if (0 === strpos($contentType, 'application/json')) {
                $data = json_decode($request->getContent(), true);
                $request->request->replace(is_array($data) ? $data : array());
            }
        });

        $app->view(function (array $data, Request $request) use ($app) {
            $code = 200;

            if ($request->getMethod() == 'POST') {
                $code = 201;
            }
    
            if ($request->getMethod() == 'PUT' || $request->getMethod() == 'OPTIONS') {
                $code = 204;
            }
        
            return $app->json($data, $code);
        });

        $app->after(function (Request $request, Response $response) {
            $allowedHeaders = 'Server, Content-Type, Connection, X-Powered-By, Cache-Control, Date, ' .
            'Accept, Accept-Version, Content-Length, Origin, token';

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
