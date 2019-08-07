<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new \Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new Twig_Extension_Debug());

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new \Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------
$container['db'] = function ($c) {
    $db = $c['settings']['dbSettings']['db'];
    $pdo = new PDO("mysql:host=" . $db['host'] . ";dbname=" . $db['dbname'],
        $db['user'], $db['pass']);

    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};
// doctrine EntityManager
$container['em'] = function ($c) {
    $settings = $c->get('settings');
    $config = \Doctrine\ORM\Tools\Setup::createAnnotationMetadataConfiguration(
        $settings['doctrine']['meta']['entity_path'],
        $settings['doctrine']['meta']['auto_generate_proxies'],
        $settings['doctrine']['meta']['proxy_dir'],
        $settings['doctrine']['meta']['cache'],
        false
    );
    return \Doctrine\ORM\EntityManager::create($settings['doctrine']['connection'], $config);
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new \Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
    $logger->pushHandler(new \Monolog\Handler\StreamHandler($settings['logger']['path'], \Monolog\Logger::DEBUG));
    return $logger;
};




// -----------------------------------------------------------------------------
// Controller factories
// -----------------------------------------------------------------------------

$container['App\Controller\HomeController'] = function ($c) {
    return new App\Controller\HomeController($c);
};

$container['App\Controller\UserController'] = function ($container) {
    $logger = $container->get('logger');
    $userModel = $container->get('userModel');
    $view = $container->get('view');
    $sensorModel = $container->get('sensorModel');
    return new App\Controller\UserController($logger, $userModel,$view, $sensorModel);
};

$container['App\Controller\MapsController'] = function ($container) {
    $logger = $container->get('logger');
    $mapsModel = $container->get('mapsModel');
    $view = $container->get('view');

    return new App\Controller\MapsController($view, $logger, $mapsModel);
};

$container['App\Controller\SensorController'] = function ($container) {
    $logger = $container->get('logger');
    $sensorModel = $container->get('sensorModel');
    $view = $container->get('view');

    return new App\Controller\SensorController( $logger, $sensorModel,$view);
};

$container['App\Controller\AppController'] = function ($container) {
    $logger = $container->get('logger');
    $userModel = $container->get('userModel');
    $appModel = $container->get('appModel');
    $view = $container->get('view');

    return new App\Controller\AppController($view, $logger, $appModel,$userModel);
};

$container['App\Controller\DataController'] = function ($container) {
    $logger = $container->get('logger');
    $dataModel = $container->get('dataModel');
    $view = $container->get('view');

    return new App\Controller\DataController($view, $dataModel,$logger);
};


// -----------------------------------------------------------------------------
// Model factories
// -----------------------------------------------------------------------------

$container['userModel'] = function ($container) {
    $settings = $container->get('settings');
    $userModel = new App\Model\UserModel($container->get('db'));
    return $userModel;
};

$container['mapsModel'] = function ($container) {
    $settings = $container->get('settings');
    $mapsModel = new App\Model\MapsModel($container->get('db'));
    return $mapsModel;
};

$container['appModel'] = function ($container) {
    $settings = $container->get('settings');
    $appModel = new App\Model\AppModel($container->get('db'));
    return $appModel;
};

$container['sensorModel'] = function ($container) {
    $settings = $container->get('settings');
    $sensorModel = new App\Model\SensorModel($container->get('db'));
    return $sensorModel;
};

$container['dataModel'] = function ($container) {
    $settings = $container->get('settings');
    $dataModel = new App\Model\DataModel($container->get('db'));
    return $dataModel;
};


