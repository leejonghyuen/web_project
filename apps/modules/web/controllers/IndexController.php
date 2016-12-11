<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class IndexController extends ControllerBase
{
    public function indexAction()
    {

    	// var_dump( Services::getService('Interphone')->GenerateUrl( 'testing'));exit;
    	// exit;
        // try {
        //     $this->view->users = Services::getService('User')->getLast();
        // } catch (\Exception $e) {
        //     $this->flash->error($e->getMessage());
        // }

        return $this->dispatcher->forward(
                    [
                        "controller" => "visitor",
                        "action"     => "index"
                    ]
                );
    }
}
