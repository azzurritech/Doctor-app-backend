<?php

namespace App\Components\Services;

require_once "AccessToken2.php";

class RtmTokenBuilder2
{
    public static function buildToken($appId, $appCertificate, $userId, $expire)
    {
        $accessToken = new AccessToken2($appId, $appCertificate, $expire);
        $serviceRtm = new ServiceRtm($userId);

        $serviceRtm->addPrivilege($serviceRtm::PRIVILEGE_LOGIN, $expire);
        $accessToken->addService($serviceRtm);

        return $accessToken->build();
    }
}
