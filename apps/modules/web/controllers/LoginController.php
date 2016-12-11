<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class LoginController extends ControllerBase
{
    public function indexAction()
    {
    	$this->assets->addCss("css/login.css", true);
    }
}
