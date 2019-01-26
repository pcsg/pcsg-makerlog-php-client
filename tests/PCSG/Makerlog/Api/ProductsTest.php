<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Products Tests
 */
class ProductsTest extends TestCase
{
    public function testGetList()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $products = $Makerlog->getProducts()->getList();

        $this->assertNotEmpty($products);
    }

    //endregion
}