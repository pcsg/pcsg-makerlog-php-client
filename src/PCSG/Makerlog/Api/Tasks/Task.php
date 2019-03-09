<?php

/**
 * This file contains PCSG\Makerlog\Api\Tasks\Task
 */

namespace PCSG\Makerlog\Api\Tasks;

use PCSG\Makerlog\Exception;
use PCSG\Makerlog\Makerlog;

/**
 * Class Task
 * - represent a task
 *
 * @package PCSG\Makerlog\Api\Tasks
 */
class Task
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * @var integer
     */
    protected $taskId;

    /**
     * Task constructor
     *
     * @param integer $taskId
     * @param Makerlog $Makerlog - main makerlog instance
     */
    public function __construct($taskId, Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
        $this->taskId   = $taskId;
    }


}