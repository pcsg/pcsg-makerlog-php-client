<?php

/**
 * This file contains PCSG\Makerlog\Api\Stats
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Stats
 *
 * - Get Stats from Makerlog
 */
class Stats
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
     * Return the main stats from makerlog
     *
     * @return object
     * @throws Exception
     */
    public function getStats()
    {
        $Request = $this->Makerlog->getRequest()->get('/stats/world');
        $world   = json_decode($Request->getBody(), true);

        return $world;
    }

    /**
     * Return the stats of the client user
     *
     * @return object
     * @throws Exception
     */
    public function getMe()
    {
        $Request = $this->Makerlog->getRequest()->get('/stats/me');
        $world   = json_decode($Request->getBody(), true);

        return $world;
    }
}
