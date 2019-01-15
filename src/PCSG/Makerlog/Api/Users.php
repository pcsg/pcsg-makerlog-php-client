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
     * @param $makerlogUserId
     */
    public function get($makerlogUserId)
    {
        // coming soon
    }

    /**
     * Return all makerlog users
     * this should be used with caution. under certain circumstances this may lead to a loss of performance.
     *
     * @throws Makerlog\Exception
     */
    public function getList()
    {
        $Request  = Makerlog\Request::get('/users');
        $users    = json_decode($Request->getBody());
        $maxUsers = $users->count;

        $batch  = 100;
        $offset = 0;
        $result = [];

        while ($offset < $maxUsers) {
            $Request = Makerlog\Request::get('/users', [
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
}
