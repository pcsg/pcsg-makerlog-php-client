<?php

/**
 * This file contains PCSG\Makerlog\Api\Projects\Project
 */

namespace PCSG\Makerlog\Api\Projects;

use PCSG\Makerlog\Exception;
use PCSG\Makerlog\Makerlog;

/**
 * Class Project
 *
 * - a project is similar to a hashtag
 * - a project is part of a product
 *
 * @package PCSG\Makerlog\Api\Products
 */
class Project
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * @var integer
     */
    protected $projectId;

    /**
     * @var array
     */
    protected $data = null;

    /**
     * Product constructor
     *
     * @param integer $projectId
     * @param Makerlog $Makerlog - main makerlog instance
     */
    public function __construct($projectId, Makerlog $Makerlog)
    {
        $this->Makerlog  = $Makerlog;
        $this->projectId = $projectId;
    }

    //region data

    /**
     * helper method to get the project data
     * this method fetches the data only once, because of performance and spamming action
     *
     * if you want to fetch new data, use refresh()
     * but please, use this wisely
     *
     * @return object
     * @throws Exception
     */
    protected function getProjectData()
    {
        if ($this->data === null) {
            $this->data = $this->Makerlog->getProjects()->get($this->projectId);
        }

        return $this->data;
    }

    /**
     * resets the internal data of the project
     * so the data will be fetched again.
     *
     * look at getProjectData();
     */
    public function refresh()
    {
        $this->data = null;

        try {
            $this->getProjectData();
        } catch (Exception $Exception) {
        }
    }

    //endregion

    //region change

    /**
     * Delete this project
     *
     * @throws Exception
     */
    public function delete()
    {
        $this->Makerlog->getRequest()->delete('/projects/'.$this->projectId.'/');
    }

    //endregion

    //region getter

    /**
     * Return the id of the project
     *
     * @return int
     */
    public function getId()
    {
        return $this->projectId;
    }

    /**
     * Return the project name
     *
     * @return string
     * @throws Exception
     */
    public function getName()
    {
        return $this->getProjectData()->name;
    }

    /**
     * Gets user and products associated to this project / hashtag.
     *
     * @throws Exception
     */
    public function getRelated()
    {
        $this->Makerlog->getRequest()->get('/projects/'.$this->projectId.'/related/');
    }

    /**
     * Is the project private?
     *
     * @return bool
     */
    public function isPrivate()
    {
        try {
            return (bool)$this->getProjectData()->private;
        } catch (Exception $Exception) {
            return true;
        }
    }

    /**
     * Is the project public?
     *
     * @return bool
     */
    public function isPublic()
    {
        try {
            return !(bool)$this->getProjectData()->private;
        } catch (Exception $Exception) {
            return false;
        }
    }

    //endregion

    //region change, setter, update

    /**
     * Update / change the task
     *
     * @param array $options - optional, default = [
     *      "name"     => '',
     *      "private"  => false,
     *      "user"     => true
     * ]
     *
     * @throws Exception
     */
    public function update($options = [])
    {
        if (empty($options)) {
            throw new Exception("Options can't be empty", 400);
        }

        $params  = [];
        $allowed = ['name', 'private', 'user'];

        foreach ($allowed as $key) {
            if (isset($options[$key])) {
                $params[$key] = $options[$key];
            }
        }

        if (empty($params)) {
            throw new Exception(
                "Can't send the update request. Data are empty. Options has forbidden entries",
                406
            );
        }

        $this->Makerlog->getRequest()->patch('/projects/'.$this->projectId.'/', [
            'form_params' => $params
        ]);

        $this->refresh();
    }

    /**
     * Changes the project status to public
     *
     * @throws Exception
     */
    public function setToPublic()
    {
        $this->update([
            'private' => false
        ]);
    }

    /**
     * Changes the project status to private
     *
     * @throws Exception
     */
    public function setToPrivate()
    {
        $this->update([
            'private' => true
        ]);
    }

    //endregion
}
