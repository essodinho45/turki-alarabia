<?php

namespace App\Notifications;

use App\Events\NotifyUser;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class OrderWaitingTurki extends Notification
{
    private $offer_id;

    public function __construct($offer_id)
    {
        $this->offer_id = $offer_id;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class, 'database'];
    }
    public function toDatabase(object $notifiable): array
    {
        return [
            'transaction_id' => $this->offer_id,
        ];
    }

    public function toWebPush($notifiable, $notification)
    {
        event(new NotifyUser($notifiable, $notification));
        return (new WebPushMessage)
            ->title(__('Order Waiting for Approval'))
            ->body(__('buying order waiting fot approval with id: ') . $this->offer_id)
            // ->action('View account', 'view_account')
            ->options(['TTL' => 1000]);
        // ->data(['id' => $notification->id])
        // ->badge()
        // ->dir()
        // ->image()
        // ->lang()
        // ->renotify()
        // ->requireInteraction()
        // ->tag()
        // ->vibrate()
    }
}
