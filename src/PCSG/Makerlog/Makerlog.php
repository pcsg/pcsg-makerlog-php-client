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
     * @todo
     */
    public function getDiscussions()
    {
        if ($this->Notifications === null) {
            $this->Notifications = new Api\Discussions($this);
        }

        return $this->Notifications;
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
        $apiEndpoint = 'https://api.getmakerlog.com';

        if (!empty($this->options['api_endpoint'])) {
            $apiEndpoint = $this->options['api_endpoint'];
        }

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

        return new Request($apiEndpoint, $Client, $this);
    }

    //endregion
}
