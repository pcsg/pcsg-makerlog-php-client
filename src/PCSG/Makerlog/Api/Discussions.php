<?php

/**
 * This file contains PCSG\Makerlog\Api\Discussions
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Discussions
 *
 * - Get Tasks from Makerlog
 * - Need oAuth Client
 */
class Discussions
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Discussions constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * Return discussion list
     *
     * @return array
     * @throws Exception
     */
    public function getList()
    {
        $Request       = $this->Makerlog->getRequest()->get('/discussions');
        $notifications = json_decode($Request->getBody());

        return $notifications;
    }

    /**
     * Return the recent discussion list
     *
     * @return array
     * @throws Exception
     */
    public function getRecent()
    {
        $Request       = $this->Makerlog->getRequest()->get('/discussions/recent_discussions');
        $notifications = json_decode($Request->getBody());

        return $notifications;
    }
}
