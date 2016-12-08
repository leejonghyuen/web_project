<?php

namespace Modules\Modules\Web;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Assets\Manager as Assets;
use Phalcon\DiInterface;
use Phalcon\Mvc\ModuleDefinitionInterface;

class Module implements ModuleDefinitionInterface
{
    /**
     * Registers the module auto-loader
     *
     * @param DiInterface $di
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces(
            [
                'Modules\Modules\Web\Controllers' => __DIR__ . '/controllers/',
                'Modules\Models\Entities' => __DIR__ . '/../../models/entities/',
                'Modules\Models\Services' => __DIR__ . '/../../models/services/',
                'Modules\Models\Repositories' => __DIR__ . '/../../models/repositories/'
            ]
        );

        $loader->register();
    }

    /**
     * Registers the module-only services
     *
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        /**
         * Setting up the view component
         */
        $di['view'] = function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');

            return $view;
        };
    }
}
