<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ApprovedByTurki extends Notification
{
    private $transaction_id;

    public function __construct($transaction_id)
    {
        $this->transaction_id = $transaction_id;
    }

    public function via($notifiable)
    {
        return [WebPushChannel::class, 'database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'transaction_id' => $this->transaction_id,
        ];
    }
    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title(__('Transaction Approved By Turki Al-Arabia'))
            ->body(__('Turki Al-Arabia has approved transaction with id: ') . $this->transaction_id)
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
