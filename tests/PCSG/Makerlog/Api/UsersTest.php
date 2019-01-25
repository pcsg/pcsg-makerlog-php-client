<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Users Tests
 */
class UsersTest extends TestCase
{
    //region getter

    public function testFetByUsername()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $Users    = $Makerlog->getUsers();

        $DeHenne = $Users->getByUsername('dehenne');
        $this->assertIsObject($DeHenne);

        $Fajarsiddiq = $Users->getByUsername('fajarsiddiq');
        $this->assertIsObject($Fajarsiddiq);

        $Fajarsiddiq = $Users->getByUsername('fajarsiddiq');
        $this->assertIsObject($Fajarsiddiq);
    }

    //endregion
}
