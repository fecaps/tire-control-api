<?php
declare(strict_types=1);

namespace Api\Provider;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Api\Controller as Controllers;

class ControllerProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app->register(new Controllers\AuthControllerProvider);
        $app->register(new Controllers\UserControllerProvider);
    }
}
