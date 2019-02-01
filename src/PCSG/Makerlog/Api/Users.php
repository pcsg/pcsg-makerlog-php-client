<?php

/**
 * This file contains PCSG\Makerlog\Api\Users
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;
use PCSG\Makerlog\Api\Users\User;

/**
 * Class Users
 *
 * - Get Users from Makerlog
 */
class Users
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Users constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * Return a user by its id
     *
     * @param int $userId
     * @return object
     *
     * @throws Exception
     */
    public function get($userId)
    {
        $userId  = (int)$userId;
        $Request = $this->Makerlog->getRequest()->get('/users/'.$userId);
        $User    = json_decode($Request->getBody());

        if (!$User) {
            throw new Exception('User not found', 404);
        }

        return $User;
    }

    /**
     * Return a user by its id
     *
     * @param string $user - name of the user
     * @return object
     *
     * @throws Exception
     */
    public function getByUsername($user)
    {
        $Request = $this->Makerlog->getRequest()->get('/users/'.$user);
        $User    = json_decode($Request->getBody());

        if (!$User) {
            throw new Exception('User not found', 404);
        }

        return $User;
    }

    /**
     * Return the client user
     *
     * @return object
     * @throws Exception
     */
    public function getMe()
    {
        $Request = $this->Makerlog->getRequest()->get('/me/');
        $User    = json_decode($Request->getBody());

        return $User;
    }

    /**
     * Return the client user as User Object
     *
     * @return User
     * @throws Exception
     */
    public function getMeAsObject()
    {
        $Request = $this->Makerlog->getRequest()->get('/me/');
        $User    = json_decode($Request->getBody());

        return $this->getUserObject($User->username);
    }

    /**
     * Return a user object
     * easier handling for user operations
     *
     * @param string $username
     * @return User
     */
    public function getUserObject($username)
    {
        return new User($username, $this->Makerlog);
    }

    /**
     * Return all Makerlog users
     * this should be used with caution. under certain circumstances this may lead to a loss of performance.
     *
     * @throws Exception
     */
    public function getList()
    {
        $Request  = $this->Makerlog->getRequest()->get('/users');
        $users    = json_decode($Request->getBody());
        $maxUsers = $users->count;

        $batch  = 100;
        $offset = 0;
        $result = [];

        while ($offset < $maxUsers) {
            $Request = $this->Makerlog->getRequest()->get('/users', [
                'query' => [
                    'limit'  => $batch,
                    'offset' => $offset
                ]
            ]);

            $users  = json_decode($Request->getBody());
            $offset = $offset + $batch;

            // get twitter users from makerlog users
            foreach ($users->results as $user) {
                $result[] = $user;
            }
        }

        return $result;
    }

    /**
     * Return the number of users in Makerlog
     *
     * @return int
     * @throws Exception
     */
    public function count()
    {
        $Request = $this->Makerlog->getRequest()->get('/users');
        $users   = json_decode($Request->getBody());

        return (int)$users->count;
    }
}
