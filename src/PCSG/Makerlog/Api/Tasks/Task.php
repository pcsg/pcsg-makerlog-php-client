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

        try {
            $this->getTaskData();
        } catch (Exception $Exception) {
        }
    }

    /**
     * Delete this task
     *
     * @throws Exception
     */
    public function delete()
    {
        $this->Makerlog->getRequest()->delete('/tasks/'.$this->taskId.'/');
    }

    /**
     * Is this task praisable?
     *
     * @return bool
     * @throws Exception
     */
    public function canPraise()
    {
        $Request  = $this->Makerlog->getRequest()->get('/tasks/'.$this->taskId.'/can_praise/');
        $Response = json_decode($Request->getBody());

        return (bool)$Response->can_praise;
    }

    /**
     * Praise this task
     *
     * @param int $amount
     *
     * @throws Exception
     */
    public function praise($amount)
    {
        $this->Makerlog->getRequest()->post('/tasks/'.$this->taskId.'/praise/', [
            'amount' => (int)$amount
        ]);
    }

    //region normal getter of the task

    /**
     * Return the task id
     *
     * @return integer
     * @throws Exception
     */
    public function getId()
    {
        return $this->getTaskData()->id;
    }

    /**
     * Return the task content
     *
     * @return string
     * @throws Exception
     */
    public function getContent()
    {
        return $this->getTaskData()->content;
    }

    /**
     * Return the creation date
     *
     * @return string|null
     * @throws Exception
     */
    public function getCreationDate()
    {
        return $this->getTaskData()->created_at;
    }

    /**
     * Return the last update date
     *
     * @return string|null
     * @throws Exception
     */
    public function getLastUpdateDate()
    {
        return $this->getTaskData()->updated_at;
    }

    /**
     * Return the date when the task was done
     *
     * @return string|null
     * @throws Exception
     */
    public function getDoneDate()
    {
        return $this->getTaskData()->done_at;
    }

    /**
     * Return the comment count
     *
     * @return int|null
     * @throws Exception
     */
    public function getCommentCount()
    {
        return $this->getTaskData()->comment_count;
    }

    /**
     * Return the praise of this task
     * - How many praises got this task
     *
     * @return mixed
     * @throws Exception
     */
    public function getPraise()
    {
        return $this->getTaskData()->praise;
    }

    /**
     * Is the task done?
     *
     * @return bool
     * @throws Exception
     */
    public function isDone()
    {
        return (bool)$this->getTaskData()->done;
    }

    /**
     * Is the task in progress?
     *
     * @return bool
     * @throws Exception
     */
    public function isInProgress()
    {
        return (bool)$this->getTaskData()->in_progress;
    }

    //endregion
}
