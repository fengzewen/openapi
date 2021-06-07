<?php


namespace Hgs\Openapi\OauthClient;


class RefreshToken
{
    const REFRESH_TIME = 60 * 60 * 3;

    private $id;
    private $expiresAt;

    /**
     * RefreshToken constructor.
     * @param $id
     */
    public function __construct($id, $expiresAt)
    {
        $this->id = $id;
        $this->expiresAt = $expiresAt;
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

    public function notTimeToRefresh(): bool
    {
        if ($this->getExpiresAt() >= (time() - self::REFRESH_TIME)) {
            return true;
        }
        return false;
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


}
