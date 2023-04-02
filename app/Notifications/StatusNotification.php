<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Telegram\TelegramMessage;

class StatusNotification extends Notification
{
    use Queueable;

    public function __construct(
        private array $data
    ) {}

    public function via():array
    {
        return ['telegram'];
    }

    public function toTelegram(mixed $notifiable)
    {
        return TelegramMessage::create()
            ->content($this->data['content']);
    }

    public function toArray(mixed $notifiable):array
    {
        return [
            //
        ];
    }
}
