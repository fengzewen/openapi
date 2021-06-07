<?php


namespace Hgs\Openapi\Base;

use Hgs\Openapi\OauthClient\ResourceOwner;
use Hgs\Openapi\Transformer\TiktokStoreResponseTransfomer;

abstract class BusinessApiGateway
{
    private $resourceOwner;

    public function __construct($resourceOwner)
    {
        $this->resourceOwner = $resourceOwner;
    }

    /**
     * @return mixed
     */
    public function getResourceOwner(): ResourceOwner
    {
        return $this->resourceOwner;
    }

    /**
     * @param mixed $resourceOwner
     */
    public function setResourceOwner($resourceOwner): void
    {
        $this->resourceOwner = $resourceOwner;
    }

    public function requestBusinessApi($path, $params)
    {
        return HttpClient::request($this->buildUrl($path, $params), TiktokStoreResponseTransfomer::class);
    }

    protected abstract function buildUrl($path, $params);
}
