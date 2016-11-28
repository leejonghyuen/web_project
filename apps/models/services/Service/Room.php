<?php
namespace Modules\Models\Services\Service;

use Modules\Models\Entities\Interphone as EntityInterphone;

class Room
{
    public function GetUserInterphones( $ownerAddress)
    {
        return EntityInterphone::find( $ownerAddress);
    }

    public function GenerateUrl()
    {
        return $this->CreateUrl();
    }

    public function NotificationToOwner( $ownerAddress, $interphoneType)
    {

    }

    private function CreateUrl()
    {
        $di = \Phalcon\Di::getDefault();
        $oSecurity = $di->get('security');
        $oRandom = $oSecurity->getRandom();

        return $oRandom->base64Safe();
    }
}
