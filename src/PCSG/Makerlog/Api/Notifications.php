<?php

/**
 * This file contains PCSG\Makerlog\Api\Notifications
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Tasks
 *
 * - Get Tasks from Makerlog
 * - Need oAuth Client
 */
class Notifications
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Projects constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * @return array
     * @throws Exception
     */
    public function get()
    {
        $Request = $this->Makerlog->getRequest()->get('/notifications');
        $projects = json_decode($Request->getBody());

        return $projects;
    }

    /**
     * Return the number of unread notifications
     * This can use for polling
     *
     * @return integer
     * @throws Exception
     */
    public function getUnreadCount()
    {
        $Request = $this->Makerlog->getRequest()->get('/notifications/unread_count');
        $projects = json_decode($Request->getBody());

        return (int)$projects->unread_count;
    }

    /**
     * Mark a notification as read
     *
     * @param integer $notificationId
     * @return mixed
     * @throws Exception
     *
     * @todo currently not tested
     */
    public function markRead($notificationId)
    {
        $notificationId = (int)$notificationId;

        $Request = $this->Makerlog->getRequest()->post('/notifications/' . $notificationId . '/mark_read');
        $projects = json_decode($Request->getBody());

        return $projects;
    }

    /**
     * Mark all notifications as read
     *
     * @return mixed
     * @throws Exception
     *
     * @todo currently not tested
     */
    public function markAllRead()
    {
        $Request = $this->Makerlog->getRequest()->post('/notifications/mark_all_read');
        $projects = json_decode($Request->getBody());

        return $projects;
    }
}
