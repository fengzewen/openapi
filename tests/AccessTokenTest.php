<?php


namespace tiktok;

use App\OpenApi\Factory\BusinessApiGatewayFactory;
use App\OpenApi\Tiktok\Store\TiktokStoreApiGateway;

class AccessTokenTest extends \TestCase
{
    public function testGetAccessToken()
    {
        $apiGateway = BusinessApiGatewayFactory::getTiktokBusinessApiGateway(TiktokStoreApiGateway::class, env("TIKTOK_STORE_APP_KEY"), env("TIKTOK_STORE_APP_SECRET"), 1);
        var_dump($apiGateway->getResourceOwner()->getToken());
    }

    public function testRefreshAccessToken()
    {
    }
}
