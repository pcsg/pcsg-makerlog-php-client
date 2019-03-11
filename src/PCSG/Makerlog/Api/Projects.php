<?php

/**
 * This file contains PCSG\Makerlog\Api\Projects
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Api\Projects\Project;
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

    /**
     * Return a project / tag
     *
     * @param integer $id
     * @return object
     *
     * @throws Exception
     */
    public function get($id)
    {
        $Request = $this->Makerlog->getRequest()->get('/projects/' . $id);
        $product = json_decode($Request->getBody());

        return $product;
    }

    /**
     * Return a specific project / tag
     *
     * @param integer $projectId
     * @return Project
     */
    public function getProjectAsObject($projectId)
    {
        return new Project($projectId, $this->Makerlog);
    }

    /**
     * Create a new project and return it
     *
     * @param string $name - Name of the project - not longer than 50 signs
     * @param bool $private - optional, is the project (tag) private or public?
     * @return Project
     *
     * @throws Exception
     */
    public function createProject($name, $private = false)
    {
        if (empty($name)) {
            throw new Exception('Name is required.', 400);
        }

        // cleanup name
        if (mb_strlen($name) >= 50) {
            $name = mb_substr($name, 0, 50);
        }

        $name = ucwords($name, '-');
        $name = ucwords($name, ' ');

        $name = str_replace('-', '', $name);
        $name = str_replace(' ', '', $name);
        $name = trim($name);
        $name = trim($name, '#');


        // post project
        $Request = $this->Makerlog->getRequest()->post('/projects/', [
            'form_params' => [
                'name'    => $name,
                'private' => (bool)$private
            ]
        ]);

        $Response = json_decode($Request->getBody());

        return $this->getProjectAsObject($Response->id);
    }
}
