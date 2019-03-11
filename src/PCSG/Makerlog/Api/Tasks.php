<?php

/**
 * This file contains PCSG\Makerlog\Api\Tasks
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Api\Tasks\Task;
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
        $Request = $this->Makerlog->getRequest()->get('/tasks/'.$taskId);
        $Task    = json_decode($Request->getBody());

        if (!$Task) {
            throw new Exception('Task not found', 404);
        }

        return $Task;
    }

    /**
     * Syncs tasks. Provide a last_date (ISO 8601) get parameter to sort by.
     *
     * @param array $params - Parameters: [
     *      'done' => 1,
     *      'in_progress' => 1,
     *      'limit' => 1,       // Number of results to return per page.
     *      'offset' => 1       // The initial index from which to return the results.
     * ]
     *
     * @return mixed
     * @throws Exception
     */
    public function sync($params = [])
    {
        if (!is_array($params)) {
            $params = [];
        }

        if (empty($params)) {
            $Request = $this->Makerlog->getRequest()->get('/tasks/sync/');
        } else {
            $options = [];

            $allowed = [
                'done',
                'in_progress',
                'limit',
                'offset'
            ];

            $allowed = array_flip($allowed);

            foreach ($params as $key => $value) {
                if (isset($allowed[$key])) {
                    $options[$key] = $key;
                }
            }

            $Request = $this->Makerlog->getRequest()->get('/tasks/sync/', [
                'form_params' => $options
            ]);
        }


        $Result = json_decode($Request->getBody());

        return $Result;
    }

    /**
     * This resource manages all public tasks.
     * Scopes are tasks:read, tasks:write
     *
     * @return mixed
     * @throws Exception
     */
    public function getList()
    {
        $Request = $this->Makerlog->getRequest()->get('/tasks');
        $tasks   = json_decode($Request->getBody());

        return $tasks;
    }

    /**
     * Return a specific task
     *
     * @param integer $taskId - ID of the task
     * @return Task
     */
    public function getTaskAsObject($taskId)
    {
        return new Task($taskId, $this->Makerlog);
    }

    /**
     * Create a new task
     *
     * @param $content
     * @param array $options - optional, default = [
     *      "done"        => false,
     *      "in_progress" => true
     * ]
     *
     * @return Task
     *
     * @throws Exception
     */
    public function createTask($content, $options = [])
    {
        if (empty($content)) {
            throw new Exception('Content is required.', 406);
        }

        $params = [
            'content' => $content
        ];

        $default = [
            "done"        => false,
            "in_progress" => true
        ];

        if (!is_array($options)) {
            $options = [];
        }

        foreach ($default as $key => $value) {
            if (isset($options[$key])) {
                $params[$key] = $options[$key];
                continue;
            }

            $params[$key] = $default[$key];
        }

        $Request = $this->Makerlog->getRequest()->post('/tasks/', [
            'form_params' => $params
        ]);

        $Response = json_decode($Request->getBody());

        return $this->getTaskAsObject($Response->id);
    }
}
