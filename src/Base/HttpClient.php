<?php


namespace Hgs\Openapi\Base;

use GuzzleHttp\Client;

class HttpClient
{
    public static function request($url, $responseFormater)
    {
        $response = (new Client())->get($url)->getBody()->getContents();
        $formater = new $responseFormater;
        return $formater->transform($response);
    }

}
