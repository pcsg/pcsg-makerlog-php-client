<?php

/**
 * This file contains PCSG\Makerlog\Api\Tasks
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
class Tasks
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Tasks constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * Return a task by its id
     *
     * @param int $taskId
     * @return object
     *
     * @throws Exception
     */
    public function get($taskId)
    {
        $taskId  = (int)$taskId;
        $Request = $this->Makerlog->getRequest()->get('/tasks/' . $taskId);
        $Task    = json_decode($Request->getBody(), true);

        if (!$Task) {
            throw new Exception('Task not found', 404);
        }

        return $Task;
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function getList()
    {
        $Request  = $this->Makerlog->getRequest()->get('/tasks');
        $projects = json_decode($Request->getBody(), true);

        return $projects;
    }
}
