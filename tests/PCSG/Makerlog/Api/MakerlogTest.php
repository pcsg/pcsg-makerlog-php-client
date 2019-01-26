<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Notifications Tests
 */
class MakerlogTest extends TestCase
{
    public function testGetOptions()
    {
        $this->assertIsArray(
            \MakerLogTest::getMakerlog()->getOptions()
        );
    }

    public function testGetOption()
    {
        $this->assertIsString(
            \MakerLogTest::getMakerlog()->getOption('client_id')
        );
    }
}
