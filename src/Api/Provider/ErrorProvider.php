<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Silex\Application;
use Silex\Api\BootableProviderInterface;
use Api\Exception\ValidatorException;
use Exception;

class ErrorProvider implements ServiceProviderInterface, BootableProviderInterface
{
    private $container;

    public function register(Container $container)
    {
        $this->container = $container;
    }

    public function boot(Application $app)
    {
        $app->error(function (ValidatorException $exception) use ($app) {
            return $app->json(
                [
                    'error' => $exception->getMessage(),
                    'errors' => $exception->getMessages()
                ],
                401
            );
        });

        $app->error(function (Exception $exception) use ($app) {
            return $app->json(
                ['error' => $exception->getMessage()],
                403
            );
        });
    }
}
