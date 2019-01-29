<?php

/**
 * This file contains PCSG\Makerlog\Api\Projects
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Projects
 *
 * - Get Projects from Makerlog
 * - Need oAuth Client
 */
class Projects
{
    /**s
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
     * Return all projects from makerlog
     * @todo performance tweeks
     *
     * @throws Exception
     * @return array - list of projects
     */
    public function getList()
    {
        $Request  = $this->Makerlog->getRequest()->get('/projects');
        $projects = json_decode($Request->getBody());

        return $projects;
    }
}
