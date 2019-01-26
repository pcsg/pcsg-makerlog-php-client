<?php

/**
 * This file contains PCSG\Makerlog\Api\Users\User
 */

namespace PCSG\Makerlog\Api\Users;

use PCSG\Makerlog\Exception;
use PCSG\Makerlog\Makerlog;

/**
 * Class User
 * - represent an user
 *
 * @package PCSG\Makerlog\Api\Users
 */
class User
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * @var string
     */
    protected $username;

    /**
     * @var object
     */
    protected $data = null;

    /**
     * User constructor
     *
     * @param $username
     * @param Makerlog $Makerlog - main makerlog instance
     */
    public function __construct($username, Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
        $this->username = $username;
    }

    /**
     * helper method to get the user data
     * this method fetches the data only once, because if performance and spamming issues
     *
     * if you want to fetch new data, use refresh()
     * but please, but use this wisely
     *
     * @return object
     * @throws Exception
     */
    protected function getUserData()
    {
        if ($this->data === null) {
            $this->data = $this->Makerlog->getUsers()->getByUsername($this->username);
        }

        return $this->data;
    }

    /**
     * resets the internal data of the user
     * so the data will be fetched again.
     *
     * look at getUserData();
     */
    public function refresh()
    {
        $this->data = null;
    }

    //region getter of the user data

    /**
     * Return the user id
     *
     * @return integer
     * @throws Exception
     */
    public function getId()
    {
        return $this->getUserData()->id;
    }

    /**
     * Return the username
     *
     * @return string
     * @throws Exception
     */
    public function getUsername()
    {
        return $this->getUserData()->username;
    }

    /**
     * Return the first name of the user
     *
     * @return string
     * @throws Exception
     */
    public function getFirstName()
    {
        return $this->getUserData()->first_name;
    }

    /**
     * Return the last name of the user
     *
     * @return string
     * @throws Exception
     */
    public function getLastName()
    {
        return $this->getUserData()->last_name;
    }

    /**
     * Return the maker score of the user
     *
     * @return integer
     * @throws Exception
     */
    public function getMakerScore()
    {
        return $this->getUserData()->maker_score;
    }

    //endregion

    //region getter api

    /**
     * return the activity graph of the user
     *
     * @throws Exception
     * @return object - from|avg|max|data
     */
    public function getActivityGraph()
    {
        return $this->request('activity_graph');
    }

    /**
     * return the embed of the user
     * the embed html
     *
     * @throws Exception
     * @return string
     */
    public function getEmbed()
    {
        $Request = $this->Makerlog->getRequest();
        $Reply   = $Request->get('/users/'.$this->username.'/embed/');

        return $Reply->getBody()->getContents();
    }

    //endregion

    //region action

    /**
     * Is the user following the authenticated makerlog client user
     * - Is the user following me?
     *
     * @return bool
     */
    public function isFollowing()
    {
        try {
            return (bool)$this->request('is_following');
        } catch (Exception $Exception) {
            return false;
        }
    }

    /**
     * Execute a follow to this user
     * The authenticated makerlog client user will follow these user
     *
     * @return mixed
     * @throws Exception
     */
    public function follow()
    {
        return $this->request('follow');
    }

    /**
     * Execute a follow to this user
     * The authenticated makerlog client user will un follow these user
     *
     * @return mixed
     * @throws Exception
     */
    public function unfollow()
    {
        return $this->request('unfollow');
    }

    //endregion

    /**
     * main request to get user end point stuff
     *
     * @param string $apiEndpoint
     * @return mixed
     * @throws Exception
     */
    protected function request($apiEndpoint)
    {
        $apiEndpoint = trim($apiEndpoint, '/').'/';
        $Request     = $this->Makerlog->getRequest()->get('/users/'.$this->username.'/'.$apiEndpoint);

        return json_decode($Request->getBody());

    }
}