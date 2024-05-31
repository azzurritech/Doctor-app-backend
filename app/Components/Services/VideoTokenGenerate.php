<?php

namespace App\Components\Services;

require_once "RtmTokenBuilder.php";

class VideoTokenGenerate
{
    public static function generate($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpireTs){
        return RtmTokenBuilder::buildToken($appID, $appCertificate, $channelName, $uid, $role, $privilegeExpireTs);
    }
}
?>