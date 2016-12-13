<?php
namespace Modules\Models\Services\Service;

use Modules\Models\Entities\InterphoneConnectionHistory as EntityInterphoneConnectionHistory;
use Modules\Models\Entities\User as EntityUser;

class Interphone
{
    public function GetHistory( $userId)
    {
        $oUser = EntityUser::findFirst( $userId);
        if( $oUser)
            return $oUser->InterphoneConnectionHistory->toArray();
        else
            return false;
    }

    public function GenerateUrl( $channelId)
    {
        $di = \Phalcon\Di::getDefault();
        $oRequest = $di->get('request');

        $url = 'https://' . $oRequest->getHttpHost() . '/host?channel_id=' . $channelId;
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
        $di = \Phalcon\Di::getDefault();
        $oSlack = $di->get('slack');

        $to = '@' . $hostId;
        $msg = $to . '님, 방문객이 있습니다. 인터폰 : ' . $url;
        
        $oSlack->to( $to)->send( $msg);
    }

    public function Calling( $hostId, $channelId)
    {
        $url = $this->GenerateUrl( $channelId);
        $this->NotificationToHost( $hostId, $url);
    }

    public function Connected( $userId, $visitorIp)
    {
        $oEntityICH = new EntityInterphoneConnectionHistory();

        $oEntityICH->visitorIp = $visitorIp;
        $oEntityICH->userId = $userId;

        if( $oEntityICH->save())
            return $oEntityICH->id;
        else
            return false;
    }
}