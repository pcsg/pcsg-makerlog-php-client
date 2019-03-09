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
     * @var array
     */
    protected $data = null;

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

    /**
     * helper method to get the task data
     * this method fetches the data only once, because of performance and spamming action
     *
     * if you want to fetch new data, use refresh()
     * but please, use this wisely
     *
     * @return object
     * @throws Exception
     */
    protected function getTaskData()
    {
        if ($this->data === null) {
            $this->data = $this->Makerlog->getTasks()->get($this->taskId);
        }

        return $this->data;
    }

    /**
     * resets the internal data of the tasks
     * so the data will be fetched again.
     *
     * look at getTaskData();
     */
    public function refresh()
    {
        $this->data = null;
    }

    /**
     * Delete this task
     */
    public function delete()
    {
        $this->Makerlog->getRequest()->delete('/tasks/'.$this->taskId.'/');
    }
}
