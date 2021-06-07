<?php


namespace Hgs\Openapi\OauthClient;


abstract class ResourceOwner
{
    private $id;
    private $authCode;
    private $token;

    /**
     * ResourceOwner constructor.
     * @param $id
     * @param $code
     */
    public function __construct($id = '', $authCode = '')
    {
        $this->id = $id;
        $this->authCode = $authCode;
    }

    /**
     * @return mixed
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode): void
    {
        $this->authCode = $authCode;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getToken(): AccessToken
    {
        if ($this->token) {
            return $this->token;
        }

        return $this->requestToken();
    }

    public function setToken($token)
    {
        $this->token = $token;
    }

    public abstract function requestToken();

    public abstract function refreshToken();

    protected abstract function storeToken(AccessToken $accessToken);

}
