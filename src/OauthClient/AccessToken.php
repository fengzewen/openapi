<?php


namespace Hgs\Openapi\OauthClient;


class AccessToken
{
    private $id;
    private $expiresAt;
    private $scopes;

    /**
     * @var RefreshToken
     */
    private $refreshToken;

    /**
     * AccessToken constructor.
     * @param $id
     */
    public function __construct($id, $expiresAt, $refreshToken, $scopes = '')
    {
        $this->id = $id;
        $this->expiresAt = $expiresAt;
        $this->scopes = $scopes;
        $this->refreshToken = $refreshToken;
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

    /**
     * @return mixed
     */
    public function getExpiresAt()
    {
        return $this->expiresAt;
    }

    /**
     * @param mixed $expiresAt
     */
    public function setExpiresAt($expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    /**
     * @return mixed
     */
    public function getScopes()
    {
        return $this->scopes;
    }

    /**
     * @param mixed $scopes
     */
    public function setScopes($scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * @return mixed
     */
    public function getRevoked()
    {
        return $this->revoked;
    }

    /**
     * @param mixed $revoked
     */
    public function setRevoked($revoked): void
    {
        $this->revoked = $revoked;
    }

    /**
     * @return mixed
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * @param mixed $refreshToken
     */
    public function setRefreshToken($refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }
}
