<?php

namespace Modules\Modules\Web;

use Phalcon\Loader,
    Phalcon\Mvc\View,
    Phalcon\Flash\Session as FlashSession,
    Phalcon\DiInterface,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\ModuleDefinitionInterface;

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
        $di->set(
            'view',
            function () {
                $view = new View();
                $view->setViewsDir(__DIR__ . '/views/');

                return $view;
            }
        );

        $evManager = $di->getShared('eventsManager');

        $evManager->attach(
            "dispatch:beforeException",
            function($event, $dispatcher, $exception)
            {
                // Handle 404 exceptions
                // if ($exception instanceof DispatchException) {
                //     $dispatcher->forward(
                //         array(
                //             'controller' => 'error',
                //             'action'     => 'notFound'
                //         )
                //     );

                //     return false;
                // }

                // Alternative way, controller or action doesn't exist
                switch ($exception->getCode()) {
                    case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
                    case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                        $dispatcher->forward(
                            array(
                                'controller' => 'error',
                                'action'     => 'notFound'
                            )
                        );

                        return false;
                    default:
                        $dispatcher->forward(
                            array(
                                'controller' => 'error',
                                'action' => 'index'
                            )
                        );
                        return false;

                        break;
                }
            }
        );

        $di->get('dispatcher')->setEventsManager( $evManager);

        $di->set(
            "flashSession",
            function () {
                return new FlashSession(
                    [
                        "error"   => "alert alert-danger",
                        "success" => "alert alert-success",
                        "notice"  => "alert alert-info",
                        "warning" => "alert alert-warning",
                    ]
                );
            }
        );

    }
}
