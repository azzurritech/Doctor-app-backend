<?php

namespace App\Components\Services;

require_once "AccessToken2.php";

class FpaTokenBuilder
{
    public static function buildToken($appId, $appCertificate)
    {
        $token = new AccessToken2($appId, $appCertificate, 24 * 3600);
        $serviceFpa = new ServiceFpa();

        $serviceFpa->addPrivilege($serviceFpa::PRIVILEGE_LOGIN, 0);
        $token->addService($serviceFpa);

        return $token->build();
    }
}
