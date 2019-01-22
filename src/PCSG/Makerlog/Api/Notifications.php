<?php

/**
 * This file contains PCSG\Makerlog\Api\Notifications
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Tasks
 *
 * - Get Tasks from Makerlog
 * - Need oAuth Client
 */
class Notifications
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Projects constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function get()
    {
        $Request = $this->Makerlog->getRequest()->get('/notifications');
        $projects = json_decode($Request->getBody());

        return $projects;
    }
}
