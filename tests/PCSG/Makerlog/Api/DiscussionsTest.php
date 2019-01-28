<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Discussions Tests
 */
class DiscussionsTest extends TestCase
{
    //region getter

    public function testGetList()
    {
        $Makerlog    = \MakerLogTest::getMakerlog();
        $discussions = $Makerlog->getDiscussions()->getList();

        $this->assertNotEmpty($discussions);
    }

    public function testGetRecent()
    {
        $Makerlog    = \MakerLogTest::getMakerlog();
        $discussions = $Makerlog->getDiscussions()->getRecent();

        $this->assertNotEmpty($discussions);
    }

    //endregion
}