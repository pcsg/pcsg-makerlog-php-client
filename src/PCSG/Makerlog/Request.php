<?php

/**
 * This file contains PCSG\Makerlog\Request
 */

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
    protected $apiUrl = '';

    /**
     * @var GuzzleHttp\Client
     */
    protected $Client;

    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Request constructor.
     *
     * @param string $apiUrl
     * @param GuzzleHttp\Client $Client
     * @param Makerlog $Makerlog
     */
    public function __construct($apiUrl, GuzzleHttp\Client $Client, Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
        $this->Client   = $Client;
        $this->apiUrl   = $apiUrl;
    }

    /**
     * Send a get request
     *
     * @param string $url
     * @param array $options
     * @throws Exception
     *
     * @return  \Psr\Http\Message\ResponseInterface
     */
    public function get($url, $options = [])
    {
        try {
            $Response = $this->request('GET', $url, $options);
        } catch (Exception $Exception) {
            if ($Exception->getCode() == 403) {
                $this->refreshToken($Exception);
            }

            $Response = $this->request('GET', $url, $options);
        }

        return $Response;
    }

    /**
     * Send a post request
     *
     * @param string $url
     * @param array $options
     * @throws Exception
     *
     * @return  \Psr\Http\Message\ResponseInterface
     */
    public function post($url, $options = [])
    {
        try {
            $Response = $this->request('POST', $url, $options);
        } catch (Exception $Exception) {
            if ($Exception->getCode() == 403) {
                $this->refreshToken($Exception);
            }

            $Response = $this->request('POST', $url, $options);
        }

        return $Response;
    }

    /**
     * send request and get response object
     *
     * @param string $method - GET, POST, PUSH
     * @param string $url
     * @param array $options
     * @throws Exception
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function request($method, $url, $options)
    {
        try {
            $Request = $this->Client->request($method, $this->apiUrl . $url, $options);
        } catch (GuzzleHttp\Exception\GuzzleException $Exception) {
            throw new Exception(
                $Exception->getMessage(),
                $Exception->getCode()
            );
        } catch (\Exception $Exception) {
            throw new Exception(
                $Exception->getMessage(),
                $Exception->getCode()
            );
        }

        return $Request;
    }

    /**
     * @param null|Exception $Exception
     * @throws Exception
     */
    protected function refreshToken($Exception = null)
    {
        try {
            $Response = $this->Client->request('POST', $this->apiUrl . '/oauth/token/', [
                'grant_type'    => 'refresh_token',
                'refresh_token' => $this->Makerlog->getOption('refresh_token'),
                'client_id'     => $this->Makerlog->getOption('client_id'),
                'client_secret' => $this->Makerlog->getOption('client_secret')
            ]);
        } catch (GuzzleHttp\Exception\GuzzleException $RequestException) {
            if ($Exception) {
                throw $Exception;
            }

            throw new Exception(
                $RequestException->getMessage(),
                $RequestException->getCode()
            );
        }

        // @todo refresh token
        $body = $Response->getBody();
    }
}
