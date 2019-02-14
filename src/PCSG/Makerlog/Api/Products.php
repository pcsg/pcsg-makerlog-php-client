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
     * @return array - list of products
     */
    public function getList()
    {
        $Request  = $this->Makerlog->getRequest()->get('/products');
        $products = json_decode($Request->getBody());

        return $products;
    }

    /**
     * Return a product
     *
     * @param $slug
     * @throws Exception
     * @return object
     */
    public function get($slug)
    {
        $Request = $this->Makerlog->getRequest()->get('/products/'.$slug);
        $product = json_decode($Request->getBody());

        return $product;
    }

    /**
     * Return recent launched products
     *
     * @return array
     * @throws Exception
     */
    public function getRecentlyLaunched()
    {
        $Request  = $this->Makerlog->getRequest()->get('/products/recently_launched');
        $products = json_decode($Request->getBody());

        return $products;
    }
}
