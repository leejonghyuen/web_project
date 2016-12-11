<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class InterphoneController extends ControllerBase
{
    public function CallingAction()
    {
        $this->view->disable();
        if( $this->request->isPost()) {
            if( $this->security->checkToken()) {
                $rslt = Services::getService('Interphone')->Calling(
                    $this->session->get('hostId'),
                    $this->request->getPost('channelId')
                );

                echo json_encode( $rslt);
            }
        }
    }

    public function openedAction()
    {
        $this->view->disable();
        if( $this->request->isPost()) {
            if( $this->security->checkToken()) {
                $hostId = $this->session->auth->id;
                $rslt = Services::getService('Doorlock')->Open( $hostId);

		        $this->response->setContent( json_encode(['abc' => 'testing']));
		        return $this->response;
            }
        }
    }
}
