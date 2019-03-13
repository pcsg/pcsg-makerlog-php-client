<?php

/**
 * This file contains PCSG\Makerlog\Api\Products
 */

namespace PCSG\Makerlog\Api;

use GuzzleHttp\RequestOptions;
use PCSG\Makerlog\Api\Products\Product;
use PCSG\Makerlog\Api\Projects\Project;
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

    /**
     * Return a specific product
     *
     * @param integer $productSlug - Slug of the product
     * @return Product
     */
    public function getProductAsObject($productSlug)
    {
        return new Product($productSlug, $this->Makerlog);
    }

    /**
     * Create a new product and return it
     *
     * @param string $name - Name of the product
     * @param string $description - Description of the product
     * @param array projects - optional, List of projects (its like tags), if projects are empty, one will be created
     * @param array $options - optional
     * @return Product
     *
     * @throws Exception
     */
    public function createProduct($name, $description, $projects = [], $options = [])
    {
        if (empty($name)) {
            throw new Exception('Name is required.', 400);
        }

        if (empty($description)) {
            throw new Exception('Description is required.', 400);
        }

        if (empty($projects)) {
            $Project  = $this->Makerlog->getProjects()->createProject($name);
            $projects = [$Project->getId()];
        }

        if (!is_array($projects)) {
            throw new Exception('Must be an array of projects', 400);
        }

        $projectQuery = [];

        foreach ($projects as $project) {
            if ($project instanceof Project) {
                $projectQuery[] = $project->getId();
                continue;
            }

            if (is_object($project)) {
                $projectQuery[] = $project->id;
                continue;
            }

            if (is_int($project)) {
                $projectQuery[] = $project;
            }
        }


        $params = [
            'name'        => $name,
            'description' => $description,
            'projects'    => $projectQuery
        ];

        $default = [
            "product_hunt" => '',
            "twitter"      => '',
            'website'      => '',
            'launched'     => false,
            'icon'         => ''
        ];

        if (!is_array($options)) {
            $options = [];
        }

        foreach ($default as $key => $value) {
            if (!empty($options[$key])) {
                $params[$key] = $options[$key];
                continue;
            }
        }

        $Request = $this->Makerlog->getRequest();
        $Request = $Request->post('/products/', [
            RequestOptions::JSON => $params
        ]);

        $Response = json_decode($Request->getBody());

        return $this->getProductAsObject($Response->slug);
    }
}
