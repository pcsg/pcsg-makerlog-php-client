<?php


/**
 * This file contains PCSG\Makerlog\Request
 */

namespace PCSG\Makerlog;

use PCSG\Makerlog\Api;
use GuzzleHttp;

/**
 * Class Makerlog
 * - Main Makerlog API class
 *
 * @package PCSG\Makerlog
 */
class Makerlog
{
    /**
     * @var Api\Users
     */
    protected $Users = null;

    /**
     * @var Api\Notifications
     */
    protected $Notifications = null;

    /**
     * @var Api\Projects
     */
    protected $Projects = null;

    /**
     * @var Api\Products
     */
    protected $Products = null;

    /**
     * @var Api\Tasks
     */
    protected $Tasks = null;

    /**
     * @var Api\Discussions
     */
    protected $Discussions = null;

    /**
     * @var Api\Stats
     */
    protected $Stats = null;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * Makerlog constructor.
     *
     * @param array $options - optional: if your api point needs an oauth this must be passed
     *
     * options:
     * - client_id
     * - client_secret
     * - api_endpoint
     * - access_token
     * - refresh_token
     * - debug
     */
    public function __construct($options = [])
    {
        $allowed = [
            'client_id',
            'client_secret',
            'api_endpoint',
            'access_token',
            'refresh_token',
            'debug'
        ];

        // defaults
        $this->options['debug'] = false;

        foreach ($allowed as $item) {
            if (isset($options[$item])) {
                $this->options[$item] = $options[$item];
            }
        }
    }

    /**
     * Makerlog is awesome!!
     *
     * @return string
     */
    public function isAwesome()
    {
        $awesome = '<pre>
 __  __          _  ________ _____  _      ____   _____ 
|  \/  |   /\   | |/ /  ____|  __ \| |    / __ \ / ____|
| \  / |  /  \  | \' /| |__  | |__) | |   | |  | | |  __ 
| |\/| | / /\ \ |  < |  __| |  _  /| |   | |  | | | |_ |
| |  | |/ ____ \| . \| |____| | \ \| |___| |__| | |__| |
|_|  |_/_/    \_\_|\_\______|_|  \_\______\____/ \_____|
                                                        
  is awesome!
  
</pre>';

        if (php_sapi_name() === 'cli') {
            return strip_tags($awesome);
        }

        return $awesome;
    }

    //region options

    /**
     * Return a wanted option
     *
     * @param string $option
     * @return mixed
     */
    public function getOption($option)
    {
        return $this->options[$option];
    }

    /**
     * Return all options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * set a option for the makerlog client
     *
     * @param string $option - name of the option eq: client_id, client_secret, debug and so on
     * @param mixed $value - value of the option
     */
    public function setOption($option, $value)
    {
        $this->options[$option] = $value;
    }

    //endregion

    //region api getters

    /**
     * Return the stats api object
     *
     * @return Api\Stats
     */
    public function getStats()
    {
        if ($this->Stats === null) {
            $this->Stats = new Api\Stats($this);
        }

        return $this->Stats;
    }

    /**
     * Returns the users api object
     *
     * @return Api\Users
     */
    public function getUsers()
    {
        if ($this->Users === null) {
            $this->Users = new Api\Users($this);
        }

        return $this->Users;
    }

    /**
     * Returns the project api object
     *
     * @return Api\Projects
     */
    public function getProjects()
    {
        if ($this->Projects === null) {
            $this->Projects = new Api\Projects($this);
        }

        return $this->Projects;
    }

    /**
     * Returns the products api object
     *
     * @return Api\Products
     */
    public function getProducts()
    {
        if ($this->Products === null) {
            $this->Products = new Api\Products($this);
        }

        return $this->Products;
    }

    /**
     * Returns the tasks api object
     *
     * @return Api\Tasks
     * @see not usable at the moment, api are not ready
     */
    public function getTasks()
    {
        if ($this->Tasks === null) {
            $this->Tasks = new Api\Tasks($this);
        }

        return $this->Tasks;
    }

    /**
     * Returns the notifications api object
     *
     * @return Api\Notifications
     */
    public function getNotifications()
    {
        if ($this->Notifications === null) {
            $this->Notifications = new Api\Notifications($this);
        }

        return $this->Notifications;
    }

    /**
     * Returns the discussions api object
     *
     * @return Api\Discussions
     */
    public function getDiscussions()
    {
        if ($this->Discussions === null) {
            $this->Discussions = new Api\Discussions($this);
        }

        return $this->Discussions;
    }

    //endregion

    //region request

    /**
     * Return a request object
     * This object is responsible for communication with the Makerlog API
     *
     * @return Request
     */
    public function getRequest()
    {
        if (!empty($this->options['access_token'])) {
            $Client = new GuzzleHttp\Client([
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->options['access_token'],
                    'Content-Type'  => 'application/json'
                ],
                'debug'   => $this->options['debug']
            ]);
        } else {
            $Client = new GuzzleHttp\Client([
                'debug' => $this->options['debug']
            ]);
        }

        return new Request($this->getApiEndpoint(), $Client, $this);
    }

    /**
     * Return a new token if the told tokens are expired
     *
     * @throws Exception
     */
    public function getRefreshToken()
    {
        $Curl         = curl_init();
        $clientId     = $this->getOption('client_id');
        $clientSecret = $this->getOption('client_secret');

        curl_setopt($Curl, CURLOPT_URL, $this->getApiEndpoint() . '/oauth/token/');
        curl_setopt($Curl, CURLOPT_USERPWD, $clientId . ":" . $clientSecret);
        curl_setopt($Curl, CURLOPT_POST, 1);
        curl_setopt($Curl, CURLOPT_POSTFIELDS, http_build_query([
            'grant_type'    => 'refresh_token',
            'refresh_token' => $this->getOption('refresh_token')
        ]));

        curl_setopt($Curl, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($Curl);
        curl_close($Curl);

        $result = json_decode($result, true);

        if (isset($result['error'])) {
            throw new Exception($result['error']);
        }

        return $result;
    }

    /**
     * Return the api endpoint
     *
     * @return mixed|string
     */
    protected function getApiEndpoint()
    {
        $apiEndpoint = 'https://api.getmakerlog.com';

        if (!empty($this->options['api_endpoint'])) {
            $apiEndpoint = $this->options['api_endpoint'];
        }

        return $apiEndpoint;
    }

    //endregion
}
