<?php

namespace JLM\MonCash;

use JLM\MonCash\Utils\Constants;

class Configurations
{
    /**
     * Static function returning the required config variables and uri for Production environment welcome
     * @return array
     */
    public static function getProdConfigs()
    {
        return array(
            "config_type" => Constants::$LIVE,
            "redirect" => Constants::$LIVE_REDIRECT,
            "rest_api_endpoint" => Constants::$REST_LIVE_ENDPOINT,
        );
    }

    /**
     * Static function returning the required config variables and uri for Sanbox environment welcome
     * @return array
     */
    public static function getSandboxConfigs()
    {
        return array(
            "config_type" => Constants::$SANDBOX,
            "redirect" => Constants::$SANDBOX_REDIRECT,
            "rest_api_endpoint" => Constants::$REST_SANDBOX_ENDPOINT,
        );
    }
}