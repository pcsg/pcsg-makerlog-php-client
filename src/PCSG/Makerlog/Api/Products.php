<?php

/**
 * This file contains PCSG\Makerlog\Api\Products
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Products
 *
 * - Get Products from Makerlog
 * - Need oAuth Client
 */
class Products
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Products constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * Return all products from makerlog
     * @todo performance tweeks
     *
     * @throws Exception
     * @return array - list of projects
     */
    public function getList()
    {
        $Request  = $this->Makerlog->getRequest()->get('/products');
        $projects = json_decode($Request->getBody());

        return $projects;
    }

    /**
     * Return a product
     *
     * @param $slug
     * @throws Exception
     * @return array - list of projects
     */
    public function get($slug)
    {
        $Request  = $this->Makerlog->getRequest()->get('/products/'.$slug);
        $projects = json_decode($Request->getBody());

        return $projects;
    }

    /**
     * Return recent launched products
     *
     * @return mixed
     * @throws Exception
     */
    public function getRecentlyLaunched()
    {
        $Request  = $this->Makerlog->getRequest()->get('/products/recently_launched');
        $projects = json_decode($Request->getBody());

        return $projects;
    }
}
