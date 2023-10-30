<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class OrderCreated extends Notification
{
    private $transaction_id;

    public function __construct($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction_id,
        ];
    }

    public function toFcm($notifiable)
    {
        return FcmMessage::create()
            ->setData(['data' => 'value'])
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle(__('Buying Order Created'))
                ->setBody(__('buying order created with id: ').$this->transaction_id)
            );
    }
}
