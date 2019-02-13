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

    //region normal getter of the user data

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
     * Return the description of the user
     *
     * @return string
     * @throws Exception
     */
    public function getDescription()
    {
        return $this->getUserData()->description;
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

    /**
     * Return the streak of the user
     *
     * @return mixed
     * @throws Exception
     */
    public function getStreak()
    {
        return $this->getUserData()->streak;
    }

    /**
     * Return the streak end of the user
     *
     * @return string - date time (2019-01-27T00:00:00.843020Z)
     * @throws Exception
     */
    public function getStreakEnd()
    {
        return $this->getUserData()->streak_end_date;
    }

    /**
     * Return the header of the user
     *
     * @return mixed
     * @throws Exception
     */
    public function getHeader()
    {
        return $this->getUserData()->header;
    }

    /**
     * Return the avatar of the user
     *
     * @return string
     * @throws Exception
     */
    public function getAvatar()
    {
        return $this->getUserData()->avatar;
    }

    /**
     * Return the accent color of the user
     *
     * @return string
     * @throws Exception
     */
    public function getAccent()
    {
        return $this->getUserData()->accent;
    }

    /**
     * Return the timezone of the user
     *
     * @return string - eq: UTC
     * @throws Exception
     */
    public function getTimeZone()
    {
        return $this->getUserData()->timezone;
    }

    //endregion

    //region is*

    /**
     * Is the user verified?
     *
     * @return bool
     */
    public function isVerified()
    {
        try {
            return (bool)$this->getUserData()->verified;
        } catch (Exception $Exception) {
            return false;
        }
    }

    /**
     * Is the user a makerlog tester?
     *
     * @return bool
     */
    public function isTester()
    {
        try {
            return (bool)$this->getUserData()->tester;
        } catch (Exception $Exception) {
            return false;
        }
    }

    /**
     * Is the user currently live?
     * Does he stream?
     *
     * @return bool
     */
    public function isLive()
    {
        try {
            return (bool)$this->getUserData()->is_live;
        } catch (Exception $Exception) {
            return false;
        }
    }

    /**
     * Has the user the gold status?
     *
     * @return bool
     */
    public function isGold()
    {
        try {
            return (bool)$this->getUserData()->gold;
        } catch (Exception $Exception) {
            return false;
        }
    }

    //endregion

    //region get handles

    /**
     * Return all handles of the user
     *
     * @return array
     * @throws Exception
     */
    public function getHandles()
    {
        $this->getUserData();

        return [
            'twitter'     => $this->getTwitterHandle(),
            'instagram'   => $this->getInstagramHandle(),
            'productHunt' => $this->getProductHuntHandle(),
            'github'      => $this->getGithubHandle(),
            'telegram'    => $this->getTelegramHandle(),
            'shipstreams' => $this->getShipstreamsHandle()
        ];
    }

    /**
     * Return the twitter handle of the user
     *
     * @return string
     * @throws Exception
     */
    public function getTwitterHandle()
    {
        return $this->getUserData()->twitter_handle;
    }

    /**
     * Return the instagram handle of the user
     *
     * @return mixed
     * @throws Exception
     */
    public function getInstagramHandle()
    {
        return $this->getUserData()->instagram_handle;
    }

    /**
     * Return the product hunt handle of the user
     *
     * @return mixed
     * @throws Exception
     */
    public function getProductHuntHandle()
    {
        return $this->getUserData()->product_hunt_handle;
    }

    /**
     * Return the github handle of the user
     *
     * @return mixed
     * @throws Exception
     */
    public function getGithubHandle()
    {
        return $this->getUserData()->github_handle;
    }

    /**
     * Return the telegram handle of the user
     *
     * @return mixed
     * @throws Exception
     */
    public function getTelegramHandle()
    {
        return $this->getUserData()->telegram_handle;
    }

    /**
     * Return the shipstreams handle
     *
     * @return mixed
     * @throws Exception
     */
    public function getShipstreamsHandle()
    {
        return $this->getUserData()->shipstreams_handle;
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
            $isFollowing = $this->request('is_following');
            $isFollowing = $isFollowing->is_following;

            return (bool)$isFollowing;
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

        return json_decode($Request->getBody(), true);
    }
}
