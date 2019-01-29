<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Tasks Tests
 *
 * @todo task api is not stable at the moment - lot of timeouts
 */
class TasksTest extends TestCase
{
    //region getter

    /*
    public function testGetList()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $tasks    = $Makerlog->getTasks()->getList();

        $this->assertNotEmpty($tasks);
    }
    */

    public function testGet()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $Task     = $Makerlog->getTasks()->get(30082);

        $this->assertNotEmpty($Task);
    }

    //endregion
}
