<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class VisitorController extends ControllerBase
{
    public function indexAction()
    {
        $this->assets->addCss("css/visitor.css", true);
        $this->assets->addJs("js/playrtc.min.js", true);
        $this->assets->addJs("js/visitor.js", true);

        $this->view->pick('visitor/index');
    }
}
