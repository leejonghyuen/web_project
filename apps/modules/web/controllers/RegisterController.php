<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class RegisterController extends ControllerBase
{
    public function indexAction()
    {
    	$this->assets->addCss("css/register.css", true);
    }
}
