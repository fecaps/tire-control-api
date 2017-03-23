<?php
declare(strict_types=1);

namespace Backend\Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Backend\Api\Controller\AuthControllerProvider;

class ControllerProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->register(new AuthControllerProvider);
    }
}
