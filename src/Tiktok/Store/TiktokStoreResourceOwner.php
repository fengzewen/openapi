<?php


namespace Hgs\Openapi\Tiktok\Store;

use Hgs\Openapi\Base\HttpClient;
use Hgs\Openapi\Factory\BusinessApiGatewayFactory;
use Hgs\Openapi\OauthClient\AccessToken;
use Hgs\Openapi\OauthClient\RefreshToken;
use Hgs\Openapi\OauthClient\ResourceOwner;
use Hgs\Openapi\OauthClient\TiktokStoreApp;
use Hgs\Openapi\Transformer\TiktokStoreResponseTransfomer;
use Illuminate\Support\Facades\DB;

class TiktokStoreResourceOwner extends ResourceOwner
{
    const MODAL_TYPE = 'tiktok_store';
    const ACCESS_TOKEN_ENDPOINT = "oauth2/access_token";
    const REFRESH_TOKEN_ENDPOINT = "oauth2/refresh_token";

    public function refreshToken()
    {
        $token = $this->getToken();
        if (!$token) {
            throw new \Exception('Token不存在');
        }

        if ($token->getRefreshToken()->notTimeToRefresh()) {
            return $token;
        }

        $app = BusinessApiGatewayFactory::getAppInstances(TiktokStoreApp::IDENTIFIER);
        $queryParams['app_id'] = $app->getAppId();
        $queryParams['app_secret'] = $app->getAppSecret();
        $queryParams['grant_type'] = 'refresh_token';
        $queryParams['refresh_token'] = $token->getRefreshToken()->getId();
        $url = sprintf("%s%s?%s", TiktokStoreApiGateway::HOST, self::REFRESH_TOKEN_ENDPOINT, http_build_query($queryParams));

        $accessTokenData = HttpClient::request($url, TiktokStoreResponseTransfomer::class);

        $refreshToken = new RefreshToken($accessTokenData['refresh_token'], time() + 60 * 60 * 24 * 14);
        $accessToken = new AccessToken($accessTokenData['access_token'], time() + $accessTokenData['expires_in'], $refreshToken);
        $this->storeToken($accessToken);
        return $accessToken;
    }

    protected function storeToken(AccessToken $accessToken)
    {
        DB::connection('admin')
            ->table('external_oauth_access_token')
            ->updateOrInsert(
                ['modal_id' => $this->getId(), 'modal_type' => self::MODAL_TYPE],
                [
                    'access_token' => $accessToken->getId(),
                    'refresh_token' => $accessToken->getRefreshToken()->getId(),
                    'refresh_token_expires_at' => date('Y-m-d H:i:s', $accessToken->getRefreshToken()->getExpiresAt()),
                    'access_token_expires_at' => date('Y-m-d H:i:s', $accessToken->getExpiresAt()),
                ]
            );
    }

    public function requestToken()
    {
        $accessTokenData = DB::connection('admin')
            ->table('external_oauth_access_token')
            ->where('modal_id', $this->getId())
            ->where('modal_type', self::MODAL_TYPE)
            ->get();

        if (!$accessTokenData->isEmpty()) {
            $refreshToken = new RefreshToken($accessTokenData->refresh_token, $accessTokenData->refresh_token_expires_at);
            return new AccessToken($accessTokenData->access_token, $accessTokenData->access_token_expires_at, $refreshToken);
        }

        return $this->auth($this->getAuthCode());
    }

    protected function auth($code): AccessToken
    {
        $grantType = $code ? 'authorization_code' : 'authorization_self';
        $app = BusinessApiGatewayFactory::getAppInstances(TiktokStoreApp::IDENTIFIER);

        $queryParams['app_id'] = $app->getAppId();
        $queryParams['app_secret'] = $app->getAppSecret();
        $queryParams['grant_type'] = $grantType;
        if (!$code) {
            $queryParams['test_shop'] = 1;
        }
        $queryParams['code'] = $code;
        $url = sprintf("%s%s?%s", TiktokStoreApiGateway::HOST, self::ACCESS_TOKEN_ENDPOINT, http_build_query($queryParams));

        $accessTokenData = HttpClient::request($url, TiktokStoreResponseTransfomer::class);

        $refreshToken = new RefreshToken($accessTokenData['refresh_token'], time() + 60 * 60 * 24 * 14);
        $accessToken = new AccessToken($accessTokenData['access_token'], time() + $accessTokenData['expires_in'], $refreshToken);
        $this->storeToken($accessToken);
        return $accessToken;
    }
}
