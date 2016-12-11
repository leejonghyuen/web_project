<?php
namespace Modules\Models\Services\Service;

use Modules\Models\Entities\Interphone as EntityInterphone;

use Modules\Models\Entities\User as EntityUser;

class Interphone
{
    public function GetUserInterphones( $ownerAddress)
    {
        return EntityInterphone::find( $ownerAddress);
    }

    public function GenerateUrl( $channelId)
    {
        $di = \Phalcon\Di::getDefault();
        $oRequest = $di->get('request');

        $url = 'https://' . $oRequest->getHttpHost() . '/host?channelId=' . $channelId;
        return $url;
    }

    public function GetHostIdByAddress( $address)
    {
        $oUser = EntityUser::findFirstByAddress( $address);
        if( $oUser)
            return $oUser->kakaoId;
        else
            return false;
    }

    private function NotificationToHost( $hostId, $url)
    {
        return $url;
    }

    public function Calling( $hostId, $channelId)
    {
        $url = $this->GenerateUrl( $channelId);
        return $this->NotificationToHost( $hostId, $url);
    }

    // private function CreateInterphoneRoomUid()
    // {
    //     $di = \Phalcon\Di::getDefault();
    //     $oSecurity = $di->get('security');
    //     $oRandom = $oSecurity->getRandom();

    //     return $oRandom->base64Safe();
    // }
}
