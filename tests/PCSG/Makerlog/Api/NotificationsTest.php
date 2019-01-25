<?php

namespace Tests\PCSG\Makerlog\Api;

use PHPUnit\Framework\TestCase;

/**
 * Notifications Tests
 */
class NotificationsTest extends TestCase
{
    //region getter

    /**
     * @throws \PCSG\Makerlog\Exception
     */
    public function testGet()
    {
        $Makerlog      = \MakerLogTest::getMakerlog();
        $Notifications = $Makerlog->getNotifications();

        $notifications = $Notifications->getList();
        $Notification  = $Notifications->get($notifications[0]->id);

        $this->assertIsObject($Notification);
    }

    /**
     * @throws \PCSG\Makerlog\Exception
     */
    public function testGetList()
    {
        $Makerlog      = \MakerLogTest::getMakerlog();
        $Notifications = $Makerlog->getNotifications();

        $notifications = $Notifications->getList();
        $this->assertNotEmpty($notifications);
    }

    /**
     * @throws \PCSG\Makerlog\Exception
     */
    public function testGetUnreadCount()
    {
        $Makerlog = \MakerLogTest::getMakerlog();
        $this->assertIsInt($Makerlog->getNotifications()->getUnreadCount());
    }

    //endregion
}
