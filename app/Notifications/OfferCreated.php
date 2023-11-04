<?php

namespace App\Notifications;

use App\Events\NotifyUser;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class OfferCreated extends Notification
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
        broadcast(new NotifyUser($notifiable, $notification));
        return (new WebPushMessage)
            ->title(__('Price Offer Created'))
            ->body(__('price offer created with id: ') . $this->offer_id)
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
