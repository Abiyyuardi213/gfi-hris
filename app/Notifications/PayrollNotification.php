<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayrollNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $period;

    public function __construct($period)
    {
        $this->period = $period;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'info',
            'title' => 'Slip Gaji Tersedia',
            'message' => 'Slip gaji periode ' . $this->period . ' telah terbit.',
            'status' => 'Info',
        ];
    }
}
