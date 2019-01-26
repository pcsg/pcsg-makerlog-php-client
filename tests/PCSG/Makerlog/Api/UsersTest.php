<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Users Tests
 */
class UsersTest extends TestCase
{
    //region getter

    public function testGetByUsername()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $Users    = $Makerlog->getUsers();

        $DeHenne = $Users->getByUsername('dehenne');
        $this->assertIsObject($DeHenne);

        $Fajarsiddiq = $Users->getByUsername('fajarsiddiq');
        $this->assertIsObject($Fajarsiddiq);

        $Sergio = $Users->getByUsername('sergio');
        $this->assertIsObject($Sergio);
    }

    public function testGet()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $Users    = $Makerlog->getUsers();

        $DeHenne = $Users->get(892);

        $this->assertEquals($DeHenne->username, 'dehenne');
    }

    public function testGetUserNotFound()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $Users    = $Makerlog->getUsers();

        $this->expectException(\PCSG\Makerlog\Exception::class);
        $Users->getByUsername('dehenne-lalalala');
    }

    public function testGetList()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $Users    = $Makerlog->getUsers();

        $list = $Users->getList();
        $this->assertGreaterThan(1000, count($list));
    }

    //endregion
}
