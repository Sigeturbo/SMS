<?php

namespace SigeTurbo\SMS;

use SigeTurbo\SMS\Resources\Account;
use SigeTurbo\SMS\Resources\Delivery;
use SigeTurbo\SMS\Resources\Message;
use SigeTurbo\SMS\Resources\Schedule;
use SigeTurbo\SMS\Resources\User;

class Client
{

    protected $request;

    /**
     * Client constructor.
     * @param $user
     * @param $token
     */
    public function __construct($user, $token)
    {
        $this->request = new Request($user, $token);
    }

    /**
     * Send Message
     * @param $to
     * @param $txt
     * @param null $campaign
     * @return mixed
     */
    public function sendMessage($to, $txt, $campaign = null)
    {
        $message = new Message($this->request);
        $deliveryToken = $message->send($to, $txt, $campaign);
        return $deliveryToken;
    }

    /**
     * Delevery Message
     * @param $deliveryToken
     * @return mixed
     */
    public function getDelivery($deliveryToken)
    {
        $delivery = new Delivery($this->request);
        $deliveryData = $delivery->get($deliveryToken);
        return $deliveryData;
    }

    /**
     * Schedule Message
     * @param $to
     * @param $txt
     * @param $date
     * @param null $campaign
     * @return mixed
     */
    public function scheduleMessage($to, $txt, $date, $campaign = null)
    {
        $scheduleResource = new Schedule($this->request);
        $scheduleId = $scheduleResource->schedule($to, $txt, $date, $campaign);

        return $scheduleId;
    }

    /**
     * Get Scheduled Message
     * @param $scheduleId
     * @return mixed
     */
    public function getScheduledMessage($scheduleId)
    {
        $scheduleResource = new Schedule($this->request);
        $schedule = $scheduleResource->get($scheduleId);

        return $schedule;
    }

    /**
     * Get Scheduled Messages
     * @return mixed
     */
    public function getScheduledMessages()
    {
        $scheduleResource = new Schedule($this->request);
        $schedules = $scheduleResource->getAll();

        return $schedules;
    }

    /**
     * Unschedule Messages
     * @param $scheduleId
     */
    public function unscheduleMessage($scheduleId)
    {
        $scheduleResource = new Schedule($this->request);
        $schedules = $scheduleResource->unschedule($scheduleId);
    }

    public function getUsers()
    {
        $userResource = new UserResource($this->request);
        $users = $userResource->getAll();
        return $users;
    }

    /**
     * Get User
     * @param $userId
     * @return mixed
     */
    public function getUser($userId)
    {
        $userResource = new User($this->request);
        $user = $userResource->get($userId);

        return $user;
    }

    /**
     * Get Account
     * @return mixed
     */
    public function getAccount()
    {
        $accountResource = new Account($this->request);
        $account = $accountResource->get();

        return $account;
    }
}