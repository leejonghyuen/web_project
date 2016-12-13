<?php

namespace Modules\Modules\Web\Controllers;

class AboutController extends ControllerBase
{
    public function indexAction()
    {
        $this->assets->addCss("css/about.css", true);
    }
}
