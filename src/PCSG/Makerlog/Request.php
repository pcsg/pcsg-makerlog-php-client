<?php

namespace PCSG\Makerlog;

use GuzzleHttp;

/**
 * Class Request
 *
 * @package PCSG\Makerlog
 */
class Request
{
    /**
     * Main Makerlog api
     *
     * @var string
     */
    protected static $apiUrl = 'https://api.getmakerlog.com';

    /**
     * Send a get request
     *
     * @param string $url
     * @param array $options
     * @throws Exception
     *
     * @return  mixed|\Psr\Http\Message\ResponseInterface
     */
    public static function get($url, $options = [])
    {
        try {
            $Guzzle  = new GuzzleHttp\Client();
            $Request = $Guzzle->request('GET', self::$apiUrl.$url, $options);
        } catch (GuzzleHttp\Exception\GuzzleException $Exception) {
            throw new Exception(
                $Exception->getMessage(),
                $Exception->getCode()
            );
        }

        return $Request;
    }
}
