<?php

namespace Hgs\Openapi\Tiktok\Store;

use Hgs\Openapi\Base\BusinessApiGateway;
use Hgs\Openapi\Factory\BusinessApiGatewayFactory;
use Hgs\Openapi\OauthClient\TiktokStoreApp;


class TiktokStoreApiGateway extends BusinessApiGateway
{
    const HOST = "https://openapi-fxg.jinritemai.com/";
    const VERSION = 2;


    protected function buildUrl($path, $params): string
    {
        $app = BusinessApiGatewayFactory::getAppInstances(TiktokStoreApp::IDENTIFIER);

        $httpQueryParams['param_json'] = $this->transformParamsToJson($params);
        $httpQueryParams['method'] = str_replace('/', '.', $path);
        $httpQueryParams['app_key'] = $app->getAppId();
        $httpQueryParams['timestamp'] = date('Y-m-d H:i:s', time());
        $httpQueryParams['v'] = self::VERSION;
        $httpQueryParams['sign'] = $this->sign($httpQueryParams, $app->getAppSecret());
        $httpQueryParams['access_token'] = $this->getResourceOwner()->getToken()->getId();

        $queryStr = http_build_query($httpQueryParams, '', '&', PHP_QUERY_RFC3986);
        return sprintf("%s%s?%s", self::HOST, $path, $queryStr);
    }

    private function transformParamsToJson($params)
    {
        ksort($params);
        return json_encode($params, JSON_FORCE_OBJECT);
    }

    private function sign($queryParams, $appSecret): string
    {
        ksort($queryParams);
        $signStr = '';
        foreach ($queryParams as $paramName => $paramValue) {
            $signStr .= $paramName . $paramValue;
        }
        return md5($appSecret . $signStr . $appSecret);
    }

}
