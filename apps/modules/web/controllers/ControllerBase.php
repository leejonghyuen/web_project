<?php
namespace Modules\Modules\Web\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public function initialize()
	{
        $this->view->setTemplateBefore('header');
        $this->view->setTemplateAfter('footer');
	}
}
