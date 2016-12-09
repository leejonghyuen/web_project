<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class VisitorController extends ControllerBase
{
    public function visitorAction()
    {
        $this->assets->addCss("css/guest.css", true);
        $this->assets->addJs("js/playrtc.min.js", true);
        $this->assets->addJs("js/guest.js", true);

        $this->view->pick('guest/index');
    }
}
