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
                        "controller" => "index",
                        "action"     => "guest"
                    ]
                );
    }

    public function guestAction()
    {
        $this->assets->addCss("css/guest.css", true);
        $this->assets->addJs("//cdnjs.cloudflare.com/ajax/libs/prototype/1.7.3/prototype.min.js", false);
        $this->assets->addJs("//www.playrtc.com/sdk/js/playrtc.js", false);
        $this->assets->addJs("js/guest.js", true);

        $this->view->pick('guest/index');
    }
}
