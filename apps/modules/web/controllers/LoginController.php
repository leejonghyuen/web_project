<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class LoginController extends ControllerBase
{
    public function indexAction()
    {
    	if( $this->session->has('auth'))
    		return $this->response->redirect('/');

    	$this->assets->addCss("css/login.css", true);
    	if( $this->request->get('channel_id'))
    		$this->view->channelId = $this->request->get('channel_id');
    }
}
