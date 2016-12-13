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
                            "email" => $oUser['email'],
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
                    $this->flashSession->error( '로그인에 실패하였습니다. 이메일과 비밀번호를 확인해주세요');

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
                    $this->flashSession->error( '다시 입력한 비밀번호가 다릅니다');
                    return $this->response->redirect( '/register');
                }

                $filter = new Filter();

                $filter->sanitize( $this->request->getPost('email'), "trim");
                $filter->sanitize( $this->request->getPost('kakaoId'), "trim");
                $filter->sanitize( $this->request->getPost('address'), "trim");

                $rslt = Services::getService('User')->Register( 
                    array(
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'kakaoId' => $this->request->getPost('kakaoId'),
                        'address' => $this->request->getPost('address')
                    )
                );
            	if( !is_array( $rslt))
                    return $this->response->redirect( '/login');
                else
                {
                    foreach( $rslt as $errorMsg)
                        $this->flashSession->error( $errorMsg);
                }

                return $this->response->redirect( '/register');
            }
        }
    }

    public function ModifyAction()
    {
        if( $this->session->has('auth') === false)
        {
            $this->flashSession->error( '로그인이 필요한 페이지 입니다');
            return $this->response->redirect('/login');
        }

        if( ( !is_null( $this->request->getPost('password'))
            || $this->request->getPost('password') !== '')
            && $this->request->getPost('password') !== $this->request->getPost('passwordRepeat'))
        {
            $this->flashSession->error( '다시 입력한 비밀번호가 다릅니다');
            return $this->response->redirect( '/mypage');
        }

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

                $oUser = Services::getService('User')->Modify(
                    $this->session->auth['id'],
                    array(
                        'email' => $this->request->getPost('email'),
                        'password' => $this->request->getPost('password'),
                        'kakaoId' => $this->request->getPost('kakaoId'),
                        'address' => $this->request->getPost('address')
                    )
                );
                if( is_array( $oUser))
                {
                    foreach( $oUser as $errorMsg)
                        $this->flashSession->error( $errorMsg);
                }
                else
                {
                    $this->session->set(
                        "auth",
                        array(
                            'id' => $this->session->auth['id'],
                            'email' => $this->request->getPost('email'),
                            'kakaoId' => $this->request->getPost('kakaoId'),
                            'address' => $this->request->getPost('address')
                        )
                    );
                }

                return $this->response->redirect( '/mypage');
            }
        }
    }

    public function logoutAction()
    {
        $this->session->destroy();

        return $this->response->redirect( '/');
    }
}
