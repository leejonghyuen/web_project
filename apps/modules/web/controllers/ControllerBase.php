<?php
namespace Modules\Modules\Web\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
	public function initialize()
	{
    	$this->assets->addCss("css/common.css", true);

        $this->view->setTemplateBefore('header');
        $headerCollection = $this->assets->collection("header");
        $headerCollection->addCss("css/header.css", true);

        $this->view->setTemplateAfter('footer');
        $footerCollection = $this->assets->collection("footer");
        $footerCollection->addCss("css/footer.css", true);
	}
}
