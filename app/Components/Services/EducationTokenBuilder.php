<?php

namespace App\Components\Services;

require_once "AccessToken2.php";

class EducationTokenBuilder
{
    public static function buildRoomUserToken($appId, $appCertificate, $roomUuid, $userUuid, $role, $expire)
    {
        $accessToken = new AccessToken2($appId, $appCertificate, $expire);

        $chatUserId = md5($userUuid);
        $serviceEducation = new ServiceEducation($roomUuid, $userUuid, $role);
        $serviceEducation->addPrivilege($serviceEducation::PRIVILEGE_ROOM_USER, $expire);
        $accessToken->addService($serviceEducation);

        $serviceRtm = new ServiceRtm($userUuid);
        $serviceRtm->addPrivilege($serviceRtm::PRIVILEGE_LOGIN, $expire);
        $accessToken->addService($serviceRtm);

        $serviceChat = new ServiceChat($chatUserId);
        $serviceChat->addPrivilege($serviceChat::PRIVILEGE_USER, $expire);
        $accessToken->addService($serviceChat);

        return $accessToken->build();
    }

    public static function buildUserToken($appId, $appCertificate, $userUuid, $expire)
    {
        $accessToken = new AccessToken2($appId, $appCertificate, $expire);
        $serviceEducation = new ServiceEducation("", $userUuid);
        $serviceEducation->addPrivilege($serviceEducation::PRIVILEGE_USER, $expire);
        $accessToken->addService($serviceEducation);

        return $accessToken->build();
    }

    public static function buildAppToken($appId, $appCertificate, $expire)
    {
        $accessToken = new AccessToken2($appId, $appCertificate, $expire);
        $serviceEducation = new ServiceEducation();
        $serviceEducation->addPrivilege($serviceEducation::PRIVILEGE_APP, $expire);
        $accessToken->addService($serviceEducation);

        return $accessToken->build();
    }
}