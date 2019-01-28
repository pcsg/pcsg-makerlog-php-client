<?php

namespace Tests\PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
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

    public function testMarkRead()
    {
        $Makerlog        = \MakerLogTest::getMakerlog();
        $MakerlogClient2 = \MakerLogTest::getMakerlog2();

        // create new message for client 2
        $DeHenneTest = $Makerlog->getUsers()->getUserObject('dehenne_php_client_test');
        $DeHenneTest->unfollow();
        $DeHenneTest->follow();

        // get notifications from dehenne_php_client_test
        $Notifications = $MakerlogClient2->getNotifications();

        $count = $Notifications->getUnreadCount();
        $this->assertNotEmpty($count);

        $list = $Notifications->getList();

        foreach ($list as $notification) {
            if ($notification->read === true) {
                continue;
            }

            // @todo if api work
            // $Notifications->markRead($notification->id);
        }

        // $count = $Notifications->getUnreadCount();
        // $this->assertEmpty($count);
    }

    public function testMarkAllRead()
    {
        $Makerlog = \MakerLogTest::getMakerlog();

        // create new message for client 2
        $DeHenneTest = $Makerlog->getUsers()->getUserObject('dehenne_php_client_test');
        $DeHenneTest->unfollow();
        $DeHenneTest->follow();

        $MakerlogClient2 = \MakerLogTest::getMakerlog2();
        $Notifications   = $MakerlogClient2->getNotifications();

        $count = $Notifications->getUnreadCount();
        $this->assertNotEmpty($count);

        // @todo if api work
        // $Notifications->markAllRead();
        // $count = $Notifications->getUnreadCount();
        // $this->assertEmpty($count);

    }

    //endregion
}
