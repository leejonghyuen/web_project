<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class HostController extends ControllerBase
{
    public function indexAction()
    {
    	$channelId = $this->request->get('channel_id');
    	if( $this->session->has('auth') === false)
    		return $this->response->redirect('/login?channel_id=' . $channelId);

        $this->assets->addCss("css/host.css", true);
        $this->assets->addJs("js/playrtc.min.js", true);
        $this->assets->addJs("js/host.js", true);

        $this->view->channelId = $channelId;
    }
}
