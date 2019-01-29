<?php

/**
 * This file contains PCSG\Makerlog\Api\Notifications
 */

namespace PCSG\Makerlog\Api;

use PCSG\Makerlog\Makerlog;
use PCSG\Makerlog\Exception;

/**
 * Class Notifications
 *
 * - Get Notifications from Makerlog
 * - Need oAuth Client
 */
class Notifications
{
    /**
     * @var Makerlog
     */
    protected $Makerlog;

    /**
     * Notifications constructor.
     *
     * @param Makerlog $Makerlog
     */
    public function __construct(Makerlog $Makerlog)
    {
        $this->Makerlog = $Makerlog;
    }

    /**
     * Return a notification by its id
     *
     * @param $notificationId
     * @return object
     *
     * @throws Exception
     */
    public function get($notificationId)
    {
        $notificationId = (int)$notificationId;
        $Request        = $this->Makerlog->getRequest()->get('/notifications/' . $notificationId);
        $projects       = json_decode($Request->getBody());

        return $projects;
    }

    /**
     * Return notification list
     *
     * @return array
     * @throws Exception
     */
    public function getList()
    {
        $Request       = $this->Makerlog->getRequest()->get('/notifications');
        $notifications = json_decode($Request->getBody());

        return $notifications;
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
        $Request  = $this->Makerlog->getRequest()->get('/notifications/unread_count');
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

        $Request  = $this->Makerlog->getRequest()->post('/notifications/' . $notificationId . '/mark_read');
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
        $Request  = $this->Makerlog->getRequest()->post('/notifications/mark_all_read');
        $projects = json_decode($Request->getBody());

        return $projects;
    }
}
