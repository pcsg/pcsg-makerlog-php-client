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

    //endregion
}
