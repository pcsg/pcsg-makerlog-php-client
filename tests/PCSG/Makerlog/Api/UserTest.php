<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * User Tests
 * Tests for the user object
 */
class UserTest extends TestCase
{
    //region getter

    public function testUserObject()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $User     = $Makerlog->getUsers()->getUserObject('dehenne');

        $this->assertIsNumeric($User->getId());
        $this->assertIsNumeric($User->getMakerScore());

        $this->assertIsString($User->getUsername());
        $this->assertIsString($User->getFirstName());
        $this->assertIsString($User->getLastName());
    }

    public function testGetActivityGraph()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $User     = $Makerlog->getUsers()->getUserObject('dehenne');

        $Activity = $User->getActivityGraph();

        $this->assertIsObject($Activity);
        $this->assertObjectHasAttribute('data', $Activity);
        $this->assertIsArray($Activity->data);
    }

    public function testGetEmbed()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $User     = $Makerlog->getUsers()->getUserObject('dehenne');
        $embed    = $User->getEmbed();

        $this->assertIsString($embed);
        $this->assertStringContainsString('<body>', $embed);
        $this->assertStringContainsString('</body>', $embed);
        $this->assertStringContainsString('<style>', $embed);
    }

    public function testFollowing()
    {
        $Makerlog2 = \MakerLogTest::getMakerlog2();
        $DeHenne   = $Makerlog2->getUsers()->getUserObject('dehenne');

        // follow dehenne
        $DeHenne->follow();
        $DeHenne->refresh();
        $this->assertTrue($DeHenne->isFollowing());

        $DeHenne->unfollow();
        $DeHenne->refresh();
        $this->assertFalse($DeHenne->isFollowing());
    }

    //endregion
}
