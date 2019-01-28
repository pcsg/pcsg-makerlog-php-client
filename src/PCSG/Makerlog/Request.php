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
     * Request constructor.
     *
     * @param string $apiUrl
     * @param GuzzleHttp\Client $Client
     */
    public function __construct(string $apiUrl, GuzzleHttp\Client $Client)
    {
        $this->Client = $Client;
        $this->apiUrl = $apiUrl;
    }

    /**
     * Send a get request
     *
     * @param string $url
     * @param array $options
     * @throws Exception
     *
     * @return  mixed|\Psr\Http\Message\ResponseInterface
     */
    public function get($url, $options = [])
    {
        try {
            $Request = $this->Client->request('GET', $this->apiUrl.$url, $options);
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
     * Send a post request
     *
     * @param string $url
     * @param array $options
     * @throws Exception
     *
     * @return  mixed|\Psr\Http\Message\ResponseInterface
     */
    public function post($url, $options = [])
    {
        try {
            $Request = $this->Client->request('POST', $this->apiUrl.$url, $options);
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
}
