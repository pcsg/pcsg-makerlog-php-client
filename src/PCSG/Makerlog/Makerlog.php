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
     * @var null|Api\Users
     */
    protected $Users = null;

    /**
     * @var null|Api\Projects
     */
    protected $Projects = null;

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
     */
    public function __construct($options = [])
    {
        $allowed = [
            'client_id',
            'client_secret',
            'api_endpoint'
        ];

        foreach ($allowed as $item) {
            if (isset($options[$item])) {
                $this->options[$item] = $options[$item];
            }
        }
    }

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
     * @todo
     */
    public function getTasks()
    {

    }

    /**
     * @todo
     */
    public function getNotifications()
    {

    }

    /**
     * @todo
     */
    public function getDiscussions()
    {

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
        $Guzzle      = new GuzzleHttp\Client();

        if (!empty($this->options['api_endpoint'])) {
            $apiEndpoint = $this->options['api_endpoint'];
        }

        // @todo oauth

        return new Request($apiEndpoint, $Guzzle);
    }

    //endregion
}