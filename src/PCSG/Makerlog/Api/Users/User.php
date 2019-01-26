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

    public function getActivityGraph()
    {

    }

    public function getEmbed()
    {

    }


    public function getFollower()
    {

    }


    public function getIsFollowing()
    {

    }

    //getter
}