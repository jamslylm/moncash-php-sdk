<?php


namespace JLM\MonCash;

USE JLM\MonCash\Utils\Constants;

class Credentials
{
    private $client;
    private $secret;
    private $configArray;

    /**
     * Credentials constructor.
     * @param $client
     * @param $secret
     * @param $configArray
     */
    public function __construct($client, $secret, $configArray)
    {
        $this->setClient($client);
        $this->setSecret($secret);
        $this->setConfigArray($configArray);
    }

    /**
     * @return string
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return string
     */
    public function getSecret()
    {
        return $this->secret;
    }

    /**
     * @return array
     */
    public function getConfigArray()
    {
        return $this->configArray;
    }

    /**
     * @param string $client
     */
    public function setClient($client)
    {
        if (!empty($client) && is_string($client)) {
            $this->client = $client;
        }
    }

    /**
     * @param string $secret
     */
    public function setSecret($secret)
    {
        if (!empty($secret) && is_string($secret)) {
            $this->secret = $secret;
        }
    }

    /**
     * @param array $configArray
     */
    public function setConfigArray($configArray)
    {
        if (!empty($configArray) && is_array($configArray)) {
            $this->configArray = $configArray;
        }
    }

    public function getAuthorizationInformations()
    {
        $restEndpointSplit = explode("//", $this->getConfigArray()["rest_api_endpoint"]);
        $httpClient = new \GuzzleHttp\Client();
        try {
            $res = $httpClient->post(
                $restEndpointSplit[0] . "//" . $this->client . ":" . $this->secret . "@" . $restEndpointSplit[1] . "" . Constants::$OAUTH_TOKEN_URI,
                array(
                    "form_params" => array(
                        "scope" => "read,write",
                        "grant_type" => "client_credentials"
                    ),
                    "headers" => array(
                        "Accept" => Constants::$HTTP_ACCEPT_HEADER
                    )
                )
            );
            return json_decode($res->getBody()->getContents(), true);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            //Have to create appropriate Exception
            var_dump($e->getMessage());
        }

        return array();
    }


}