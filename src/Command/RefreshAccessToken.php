<?php

namespace Hgs\Openapi\Command;

use Hgs\Openapi\Factory\BusinessApiGatewayFactory;
use Hgs\Openapi\OauthClient\AccessToken;
use Hgs\Openapi\OauthClient\RefreshToken;
use Hgs\Openapi\Tiktok\Store\TiktokStoreApiGateway;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshAccessToken extends Command
{
    protected $signature = 'openapi:token-refresh';

    protected $description = '刷新access token';

    public function handle()
    {
        $accessTokenData = DB::connection('admin')->table('external_oauth_access_token')->get();
        foreach ($accessTokenData as $token) {
            $refreshToken = new RefreshToken($token->refresh_token, strtotime($token->refresh_token_expires_at));
            $accessToken = new AccessToken($token->access_token, strtotime($token->access_token_expires_at), $refreshToken);

            $apiGateway = BusinessApiGatewayFactory::getTiktokBusinessApiGateway(TiktokStoreApiGateway::class, env("TIKTOK_STORE_APP_KEY"), env("TIKTOK_STORE_APP_SECRET"), $token->modal_id);
            $resourceOwner = $apiGateway->getResourceOwner();
            $resourceOwner->setToken($accessToken);
            $resourceOwner->refreshToken();
        }
    }

}
