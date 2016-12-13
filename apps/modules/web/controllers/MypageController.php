<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

use Phalcon\Filter;

class MypageController extends ControllerBase
{
    public function indexAction()
    {
        if( $this->session->has('auth') === false)
        {
            $this->flashSession->error( '로그인이 필요한 페이지 입니다');
            return $this->response->redirect('/login');
        }

        $interphoneHistories = Services::getService('Interphone')->GetHistory( $this->session->auth['id']);
        $this->view->interphoneHistories = $interphoneHistories;
        
        $this->assets->addJs("js/search.min.js", true);
    }
}
