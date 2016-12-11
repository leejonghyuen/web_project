<?php
/**
 * Services are globally registered in this file
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\DI\FactoryDefault;
use Phalcon\Session\Adapter\Files as SessionAdapter;
use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;
use Phalcon\Security;

use Whoops\Run;

$whoops = new Run;
if( getenv( 'DEV_ENV') && getenv( 'DEV_ENV') === 'develop')
{
    $whoops->pushHandler( new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
}

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

$di->set('config', function() {
    $config = new \Phalcon\Config\Adapter\Ini(__DIR__ . '/config.ini');

    return $config;
});

$di->set(
    "security",
    function () {
        $security = new Security();

        // Set the password hashing factor to 12 rounds
        $security->setWorkFactor(12);

        return $security;
    }
);

/**
 * Registering a router
 */
$di['router'] = function () {

    $router = new Router();

    $router->setDefaultModule("web");
    $router->setDefaultNamespace("Modules\Modules\Web\Controllers");
    
    $router->setUriSource(\Phalcon\Mvc\Router::URI_SOURCE_SERVER_REQUEST_URI);
    
    $router->removeExtraSlashes(true);

    return $router;
};

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di['url'] = function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');

    return $url;
};

/**
 * Start the session the first time some component request the session service
 */
$di['session'] = function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
};

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di['db'] = function () use ( $di) {
    $config = $di->get('config');
    return new DbAdapter(
        [
            "host" => $config->database->host,
            "username" => $config->database->username,
            "password" => $config->database->password,
            "dbname" => $config->database->dbname
        ]
    );
};

/*
    [PHP package for sending messages to Slack]

    https://github.com/maknz/slack
*/
$di->setShared('slack', function () use ( $di){
    $config = $di->getConfig();
    $configSlack = $config->slack;

    $settings = array(
        'username' => $configSlack->username,
        'link_names' => true
    );

    $client = new Maknz\Slack\Client( $configSlack->url, $settings);

    return $client;
});