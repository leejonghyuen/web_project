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
        $oUser->phone = $userData['phone'];
        $oUser->password = $oSecurity->hash( $userData['password']);

        if( $oUser->save())
            return $oUser->id;
        else
            return false;
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
                        'phone' => $oUser->phone
                    );
            }
            else
                return false;
        }
        return false;
    }

    public function getLast()
    {
    	return EntityUser::find(
    			array(
    				'order' => 'email DESC, phone',
    				'limit' => 1
    			)
    		);
    }
}
