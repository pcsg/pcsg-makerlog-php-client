<?php

/**
 * This file contains PCSG\Makerlog\Api\Users\User
 */

namespace PCSG\Makerlog\Api\Users;

use PCSG\Makerlog\Api\Products\Product;
use PCSG\Makerlog\Api\Projects\Project;
use PCSG\Makerlog\Api\Tasks\Task;
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
     * @param array $data - optional, data to build a project object yourself. this is only intended if data from a project already exists
     */
    public function __construct($username, Makerlog $Makerlog, $data = [])
    {
        $this->Makerlog = $Makerlog;
        $this->username = $username;

        if (is_array($data) && !empty($data)) {
            $this->data = $data;
        }
    }

    /**
     * helper method to get the user data
     * this method fetches the data only once, because of performance and spamming issues
     *
     * if you want to fetch new data, use refresh()
     * but please, use this wisely
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

        try {
            $this->getUserData();
        } catch (Exception $Exception) {
        }
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
        $Reply   = $Request->get('/users/' . $this->username . '/embed/');

        return $Reply->getBody()->getContents();
    }

    /**
     * return the embed stats of the user
     * the embed html
     *
     * @throws Exception
     * @return string
     */
    public function getEmbedStats()
    {
        $Request = $this->Makerlog->getRequest();
        $Reply   = $Request->get('/users/' . $this->username . '/stats_embed/');

        return $Reply->getBody()->getContents();
    }

    /**
     * Return the user stats
     *
     * @return mixed
     * @throws Exception
     */
    public function getStats()
    {
        $Request = $this->Makerlog->getRequest();
        $Reply   = $Request->get('/users/' . $this->username . '/stats/');
        $stats   = json_decode($Reply->getBody());

        return $stats;
    }

    /**
     * Return products of the user
     *
     * @return Project[]
     * @throws Exception - if debug is true
     */
    public function getProducts()
    {
        try {
            $Request = $this->Makerlog->getRequest();
            $Reply   = $Request->get('/users/' . $this->username . '/products/');
        } catch (Exception $Exception) {
            if ($this->Makerlog->getOption('debug')) {
                throw $Exception;
            }

            return [];
        }

        $products = json_decode($Reply->getBody());

        $result = [];

        foreach ($products as $product) {
            $result[] = new Product($product->slug, $this->Makerlog, $product);
        }

        return $result;
    }

    /**
     * Return the recent tasks of the user
     *
     * @return Task[]
     * @throws Exception - if debug is true
     */
    public function getRecentTasks()
    {
        try {
            $Request = $this->Makerlog->getRequest();
            $Reply   = $Request->get('/users/' . $this->username . '/recent_tasks/');
        } catch (Exception $Exception) {
            if ($this->Makerlog->getOption('debug')) {
                throw $Exception;
            }

            return [];
        }

        $tasks  = json_decode($Reply->getBody());
        $result = [];

        foreach ($tasks as $task) {
            $result[] = new Task($task->id, $this->Makerlog, $task);
        }

        return $result;
    }

    /**
     * Return the wrapped data
     *
     * @return \stdClass
     * @throws Exception
     */
    public function getWrapped()
    {
        $Request = $this->Makerlog->getRequest();
        $Reply   = $Request->get('/users/' . $this->username . '/wrapped/');

        $wrapped = json_decode($Reply->getBody());

        return $wrapped;
    }

    /**
     * Return the wrapped image
     *
     * @return string (binary)
     * @throws Exception
     */
    public function getWrappedImage()
    {
        $Request = $this->Makerlog->getRequest();
        $Reply   = $Request->get('/users/' . $this->username . '/wrapped_image/');

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

    /**
     * Set the weekendOff to 1
     *
     * @throws Exception
     */
    public function setWeekendOff()
    {
        $this->update([
            'weekends_off' => 1
        ]);
    }

    /**
     * Set the weekendOff to 1
     *
     * @throws Exception
     */
    public function setWeekendOn()
    {
        $this->update([
            'weekends_off' => 0
        ]);
    }

    /**
     * Updates user data
     * - change date of the user
     *
     * @param array $options
     * @throws Exception
     */
    public function update($options = [])
    {
        if (empty($options)) {
            throw new Exception("Options can't be empty", 400);
        }

        $params  = [];
        $allowed = [
            'first_name',
            'last_name',
            'description',
            'status',
            'digest',
            'accent',

            // bool
            'private',
            'dark_mode',
            'weekends_off',

            // handles
            'twitter_handle',
            'instagram_handle',
            'product_hunt_handle',
            'github_handle',
            'shipstreams_handle',
            'telegram_handle',

            // avatar
            'avatar',
            'header'
        ];

        foreach ($allowed as $key) {
            if (isset($options[$key])) {
                $params[$key] = $options[$key];
            }
        }

        if (empty($params)) {
            throw new Exception(
                "Can't send the update request. Data are empty. Options has forbidden entries",
                406
            );
        }

        $this->Makerlog->getRequest()->patch('/users/' . $this->getId() . '/', [
            'form_params' => $params
        ]);
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
        $apiEndpoint = trim($apiEndpoint, '/') . '/';
        $Request     = $this->Makerlog->getRequest()->get('/users/' . $this->username . '/' . $apiEndpoint);

        return json_decode($Request->getBody());
    }
}
