<?php

/**
 * This file contains PCSG\Makerlog\Api\Products\Product
 */

namespace PCSG\Makerlog\Api\Products;

use PCSG\Makerlog\Exception;
use PCSG\Makerlog\Makerlog;

/**
 * Class Product
 *
 * @package PCSG\Makerlog\Api\Products
 */
class Product
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * @var integer
     */
    protected $productId;

    /**
     * @var array
     */
    protected $data = null;

    /**
     * Product constructor
     *
     * @param integer $productId
     * @param Makerlog $Makerlog - main makerlog instance
     */
    public function __construct($productId, Makerlog $Makerlog)
    {
        $this->Makerlog  = $Makerlog;
        $this->productId = $productId;
    }

    //region data

    /**
     * helper method to get the product data
     * this method fetches the data only once, because of performance and spamming action
     *
     * if you want to fetch new data, use refresh()
     * but please, use this wisely
     *
     * @return object
     * @throws Exception
     */
    protected function getProductData()
    {
        if ($this->data === null) {
            $this->data = $this->Makerlog->getProducts()->get($this->productId);
        }

        return $this->data;
    }

    /**
     * resets the internal data of the product
     * so the data will be fetched again.
     *
     * look at getProductData();
     */
    public function refresh()
    {
        $this->data = null;

        try {
            $this->getProductData();
        } catch (Exception $Exception) {
        }
    }

    //endregion

    //region change

    /**
     * Delete this product
     *
     * @throws Exception
     */
    public function delete()
    {
        $this->Makerlog->getRequest()->delete('/products/' . $this->productId . '/');
    }
}
