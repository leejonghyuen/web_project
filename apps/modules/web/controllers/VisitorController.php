<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;
use Phalcon\Filter;

class VisitorController extends ControllerBase
{
    public function indexAction()
    {
        if( $this->request->isPost()) {

            $filter = new Filter();

            $filter->sanitize( $this->request->getPost('address'), "trim");

            $hostId = Services::getService('Interphone')->GetHostIdByAddress( $this->request->getPost('address'));

            if( $hostId !== false)
            {
                $this->session->set('hostId', $hostId);

                $this->assets->addCss("css/visitor.css", true);
                $this->assets->addJs("js/playrtc.min.js", true);
                $this->assets->addJs("js/visitor.js", true);

                $this->view->pick('visitor/index');
            }
            else
            {
                $this->flashSession->error( "상대방을 찾을 수 없습니다");
                $this->response->redirect('/');
            }
        }
    }

    public function openedAction()
    {
        $this->view->disable();
        if( $this->request->isPost()) {
            if( $this->security->checkToken()) {

		        $this->response->setContent( json_encode(['abc' => 'testing']));
		        return $this->response;
            }
        }
    }

    public function searchingHostAction()
    {
        $this->assets->addCss("css/searchingHost.css", true);
        $this->assets->addJs("js/search.min.js", true);

        $this->view->pick('visitor/searchingHost');
    }
}
