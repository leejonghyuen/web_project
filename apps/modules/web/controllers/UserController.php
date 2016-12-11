<?php

namespace Modules\Modules\Web\Controllers;

use Modules\Models\Services\Services;

use Phalcon\Filter;

class UserController extends ControllerBase
{
    public function loginAction()
    {
        if( $this->request->isPost()) {
            if( $this->security->checkToken()) {
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
                            "kakaoId" => $oUser['kakaoId'],
                            "address" => $oUser['address']
                        ]
                    );

                    if( $this->request->getPost('channelId'))
                        return $this->response->redirect('/host?channel_id='.$this->request->getPost('channelId'));
                    else
                        return $this->response->redirect( '/');
                }
                else
                {
                    $this->flashSession->error(
                        "로그인에 실패하였습니다."
                    );

                    if( $this->request->getPost('channelId'))
                        return $this->response->redirect( '/login?channel_id='.$this->request->getPost('channelId'));
                    else
                        return $this->response->redirect( '/login');
                }
            }
        }
    }

    public function registerAction()
    {
        if( $this->request->isPost()) {
            if ($this->security->checkToken()) {
                if( $this->request->getPost('password') !== $this->request->getPost('passwordRepeat'))
                {
                    $this->flashSession->error( '회원가입에 실패하였습니다');
                    return $this->response->redirect( '/register');
                }

                $filter = new Filter();

                $filter->sanitize( $this->request->getPost('email'), "trim");
                $filter->sanitize( $this->request->getPost('kakaoId'), "trim");
                $filter->sanitize( $this->request->getPost('address'), "trim");

            	if( Services::getService('User')->Register( 
                        array(
                    		'email' => $this->request->getPost('email'),
                    		'password' => $this->request->getPost('password'),
                            'kakaoId' => $this->request->getPost('kakaoId'),
                            'address' => $this->request->getPost('address')
            	        )
                    ))
                    return $this->response->redirect( '/login');
                else
                    $this->flashSession->error( '회원가입에 실패하였습니다');

                return $this->response->redirect( '/register');
            }
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();

        return $this->response->redirect( '/');
    }
}
