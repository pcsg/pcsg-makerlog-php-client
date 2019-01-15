<?php

/**
 * This file contains PCSG\Makerlog\Api\Users
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog;

/**
 * Class Users
 *
 * - Get Users from Makerlog
 */
class Users
{
    /**
     * Return a user by its id
     *
     * @param int $userId
     * @return object
     *
     * @throws Makerlog\Exception
     */
    public static function get($userId)
    {
        $userId = (int)$userId;
        $Request = Makerlog\Request::get('/users/' . $userId);
        $User = json_decode($Request->getBody());

        if (!$User) {
            throw new Makerlog\Exception('User not found', 404);
        }

        return $User;
    }

    /**
     * Return all Makerlog users
     * this should be used with caution. under certain circumstances this may lead to a loss of performance.
     *
     * @throws Makerlog\Exception
     */
    public static function getList()
    {
        $Request = Makerlog\Request::get('/users');
        $users = json_decode($Request->getBody());
        $maxUsers = $users->count;

        $batch = 100;
        $offset = 0;
        $result = [];

        while ($offset < $maxUsers) {
            $Request = Makerlog\Request::get('/users', [
                'query' => [
                    'limit' => $batch,
                    'offset' => $offset
                ]
            ]);

            $users = json_decode($Request->getBody());
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
     * @throws Makerlog\Exception
     */
    public function count()
    {
        $Request = Makerlog\Request::get('/users');
        $users = json_decode($Request->getBody());

        return (int)$users->count;
    }
}
