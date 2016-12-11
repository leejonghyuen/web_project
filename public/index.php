<?php

use Phalcon\Mvc\Application;

header("Content-Type: text/html; charset=UTF-8");
date_default_timezone_set('Asia/Seoul');

try {
    /**
     * Include composer autoloader
     */
    require __DIR__ . "/../vendor/autoload.php";

    /**
     * Include services
     */
    require __DIR__ . '/../apps/config/services.php';

    /**
     * Handle the request
     */
    $application = new Application();

    /**
     * Assign the DI
     */
    $application->setDI($di);

    /**
     * Include modules
     */
    require __DIR__ . '/../apps/config/modules.php';

    echo $application->handle()->getContent();
} catch (Phalcon\Exception $e) {
    echo $e->getMessage();
} catch (PDOException $e) {
    echo $e->getMessage();
}
