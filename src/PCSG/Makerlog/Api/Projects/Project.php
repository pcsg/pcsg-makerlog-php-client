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
        $this->Makerlog->getRequest()->delete('/projects/' . $this->projectId . '/');
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
     * @return mixed
     * @throws Exception
     */
    public function getName()
    {
        return $this->getProjectData()->name;
    }

    //endregion
}
