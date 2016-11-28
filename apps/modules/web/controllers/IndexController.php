<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class IndexController extends ControllerBase
{
    public function indexAction()
    {
    	// var_dump( Services::getService('User')->Register( array(
    	// 	'email' => 'grandmorning@hotmail.com',
    	// 	'password' => '1q2w3e4r',
    	// 	'phone' => '01033955249'
    	// )));

    	// var_dump( Services::getService('User')->Login( 'grandmorning@hotmail.com', '1q2w3e4r'));exit;

    	var_dump( Services::getService('Room')->GenerateUrl( 'testing'));exit;
    	exit;
        // try {
        //     $this->view->users = Services::getService('User')->getLast();
        // } catch (\Exception $e) {
        //     $this->flash->error($e->getMessage());
        // }
    }
}
