<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class HostController extends ControllerBase
{
    public function indexAction()
    {
        $this->assets->addCss("css/host.css", true);
        $this->assets->addJs("js/playrtc.min.js", true);
        $this->assets->addJs("js/host.js", true);

        $this->view->channelId = $this->request->get('channelId');
    }
}
