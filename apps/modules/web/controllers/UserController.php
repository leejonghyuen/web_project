<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

class UserController extends ControllerBase
{
    public function loginAction()
    {
        if( $this->request->isPost()) {
            if ($this->security->checkToken()) {
                $oUser = Services::getService('User')->Login(
                    $this->request->getPost('email'),
                    $this->request->getPost('password')
                );
                
                if( $oUser !== false)
                {
                    $this->session->set(
                        "auth",
                        [
                            "id"   => $oUser['id'],
                            "name" => $oUser['email'],
                            "phone" => $oUser['phone']
                        ]
                    );

                    return $this->response->redirect( '/');
                }
                else
                {
                    $this->flashSession->error(
                        "로그인에 실패하였습니다."
                    );

                    return $this->response->redirect( '/login');
                }
            }
        }
    }

    public function registerAction()
    {
        if( $this->request->isPost()) {
            if ($this->security->checkToken()) {
            	if( Services::getService('User')->Register( array(
            		'email' => $this->request->getPost('email'),
            		'password' => $this->request->getPost('password'),
            		'phone' => $this->request->getPost('phone')
            	)))
                    return $this->response->redirect( '/login');
                else
                {
                    $this->flashSession->error(
                        "회원가입에 실패하였습니다."
                    );

                    return $this->response->redirect( '/register');
                }
            }
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();

        return $this->response->redirect( '/');
    }
}
