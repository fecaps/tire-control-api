<?php
declare(strict_types=1);

chdir(__DIR__);

use Symfony\Component\Yaml\Yaml;
use Silex\Application;
use Silex\Provider\DoctrineServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$composerAutoload = 'vendor/autoload.php';

if (file_exists($composerAutoload) === false) {
    trigger_error('Please, run the composer install. ', E_USER_ERROR);
}

require_once $composerAutoload;

$parametersFile = 'config/parameters.yml';

if (file_exists($parametersFile) === false) {
    trigger_error('Parameters file not found. ', E_USER_ERROR);
}

$parameters = Yaml::parse(file_get_contents($parametersFile));

date_default_timezone_set($parameters['timezone'] ?? 'America/Sao_Paulo');

$app = new Application();

$isDevMode      = $parameters['devMode'] ?? false;
$app['debug']   = $parameters['debug'] ?? false;

$path = array(__DIR__.'/src/Api/Model');

$config         = Setup::createAnnotationMetadataConfiguration($path, $isDevMode);
$entityManager  = EntityManager::create($parameters['database']['db.options'], $config);

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new DoctrineServiceProvider, $parameters['database']);
$app->register(new Api\Provider\AuthProvider);
$app->register(new Api\Provider\ControllerProvider);
$app->register(new Api\Provider\ErrorProvider);
$app->register(new Api\Provider\ModelProvider);
$app->register(new Api\Provider\RepositoryProvider);
$app->register(new Api\Provider\ValidatorProvider);
$app->register(new Api\Provider\ViewerProvider);

return $app;
