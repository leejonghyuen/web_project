<?php
namespace Modules\Models\Services\Service;

use Modules\Models\Entities\User as EntityUser;

class User
{
    /*
        userData[email, password]
    */
    public function Register( array $userData)
    {
        $di = \Phalcon\Di::getDefault();
        $oSecurity = $di->get('security');

        $oUser = new EntityUser();

        $oUser->email = $userData['email'];
        $oUser->password = $oSecurity->hash( $userData['password']);
        $oUser->kakaoId = $userData['kakaoId'];
        $oUser->address = $userData['address'];

        if( $oUser->save())
            return $oUser->id;
        else
            return $oUser->getMessages();
    }

    public function Login( $id, $password)
    {
        $di = \Phalcon\Di::getDefault();
        $oSecurity = $di->get('security');

        $oUser = EntityUser::findFirstByEmail( $id);
        if( $oUser) {
            if( $oSecurity->checkHash( $password, $oUser->password)) {
                return array(
                        'id' => $oUser->id,
                        'email' => $oUser->email,
                        'kakaoId' => $oUser->kakaoId,
                        'address' => $oUser->address
                    );
            }
            else
                return false;
        }
        return false;
    }

    public function Modify( $userId, array $userData)
    {
        $di = \Phalcon\Di::getDefault();
        $oSecurity = $di->get('security');

        $oUser = EntityUser::findFirst( $userId);
        if( $oUser)
        {
            if( is_null( $userData['password'])
                || $userData['password'] === '')
                unset( $userData['password']);
            else
                $userData['password'] = $oSecurity->hash( $userData['password']);

            if( $oUser->update( $userData))
                return $oUser->id;
            else
                return $oUser->getMessages();
        }
        return false;
    }

    public function GetProfile( $userId)
    {
    	return EntityUser::findFirst(
            array(
                $userId,
                "columns" => "id,email,kakaoId,address"
                )
            );
    }
}
