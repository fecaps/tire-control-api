<?php
declare(strict_types=1);

namespace Backend\Api\Provider;

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
        $app->view(function (array $data, Request $request) use ($app) {
            $code = 200;

            if ($request->getMethod() == 'POST') {
                $code = 201;
            }
    
            if ($request->getMethod() == 'PUT' || $request->getMethod() == 'DELETE') {
                $code = 204;
            }
        
            return $app->json($data, $code);
        });
    }
}
