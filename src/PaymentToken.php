<?php


namespace JLM\MonCash;


class PaymentToken
{
    private $expired;
    private $created;
    private $token;

    /**
     * PaymentToken constructor.
     * @param $expired
     * @param $created
     * @param $token
     */
    public function __construct(array $paymentTokenValue)
    {
        $this->setExpired($paymentTokenValue["expired"]);
        $this->setCreated($paymentTokenValue["created"]);
        $this->setToken($paymentTokenValue["token"]);
    }

    /**
     * @return mixed
     */
    public function getExpired()
    {
        return $this->expired;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param mixed $expired
     */
    public function setExpired($expired)
    {
        if (!empty($expired)) {
            $this->expired = $expired;
        }
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        if (!empty($created)) {
            $this->created = $created;
        }
    }

    /**
     * @param mixed $token
     */
    public function setToken($token)
    {
        if (!empty($token)) {
            $this->token = $token;
        }
    }

}