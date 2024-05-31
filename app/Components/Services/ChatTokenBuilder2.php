<?php

namespace App\Components\Services;

require_once "AccessToken2.php";

class ChatTokenBuilder2
{
    public static function buildUserToken($appId, $appCertificate, $userId, $expire)
    {
        $accessToken = new AccessToken2($appId, $appCertificate, $expire);
        $serviceChat = new ServiceChat($userId);

        $serviceChat->addPrivilege($serviceChat::PRIVILEGE_USER, $expire);
        $accessToken->addService($serviceChat);

        return $accessToken->build();
    }

    public static function buildAppToken($appId, $appCertificate, $expire)
    {
        $accessToken = new AccessToken2($appId, $appCertificate, $expire);
        $serviceChat = new ServiceChat();

        $serviceChat->addPrivilege($serviceChat::PRIVILEGE_APP, $expire);
        $accessToken->addService($serviceChat);

        return $accessToken->build();
    }
}