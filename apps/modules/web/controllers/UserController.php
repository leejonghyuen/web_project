<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class UserController extends ControllerBase
{
    public function loginAction()
    {

    	var_dump( Services::getService('User')->Login( 'grandmorning@hotmail.com', '1q2w3e4r'));exit;
    }

    public function registerAction()
    {
    	Services::getService('User')->Register( array(
    		'email' => $this->request->getPost('email'),
    		'password' => $this->request->getPost('password'),
    		'phone' => $this->request->getPost('phone')
    	));
    }
}
