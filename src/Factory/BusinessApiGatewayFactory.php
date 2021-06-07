<?php


namespace Hgs\Openapi\Factory;


use Hgs\Openapi\Base\BusinessApiGateway;
use Hgs\Openapi\OauthClient\TiktokStoreApp;
use Hgs\Openapi\Tiktok\Store\TiktokStoreResourceOwner;

class BusinessApiGatewayFactory
{
    private static $appInstances;

    /**
     * @return mixed
     */
    public static function getAppInstances($identifier)
    {
        return self::$appInstances[$identifier];
    }

    public static function getTiktokBusinessApiGateway($class, $appId, $appSecret, $resourceId, $authCode = ''): BusinessApiGateway
    {
        self::$appInstances[TiktokStoreApp::IDENTIFIER] = new TiktokStoreApp($appId, $appSecret);

        $resourceOwner = new TiktokStoreResourceOwner($resourceId, $authCode);

        return new $class($resourceOwner);
    }

}
