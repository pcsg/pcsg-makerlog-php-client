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

        $this->assertIsString($User->getAvatar());
        $this->assertIsString($User->getAccent());
        $this->assertIsString($User->getDescription());
        $this->assertIsString($User->getHeader());
        $this->assertIsString($User->getTimeZone());

        $this->assertIsBool($User->isVerified());
        $this->assertIsBool($User->isTester());
        $this->assertIsBool($User->isLive());
        $this->assertIsBool($User->isGold());
    }

    public function testUserHandles()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $User     = $Makerlog->getUsers()->getUserObject('dehenne');

        $handles = $User->getHandles();

        $this->assertArrayHasKey('twitter', $handles);
        $this->assertArrayHasKey('instagram', $handles);
        $this->assertArrayHasKey('productHunt', $handles);
        $this->assertArrayHasKey('github', $handles);
        $this->assertArrayHasKey('telegram', $handles);
        $this->assertArrayHasKey('shipstreams', $handles);
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

        // following yourself doesn't work
        $this->assertFalse(
            \MakerLogTest::getMakerlog()->getUsers()->getUserObject('dehenne')->isFollowing()
        );
    }

    //endregion
}
