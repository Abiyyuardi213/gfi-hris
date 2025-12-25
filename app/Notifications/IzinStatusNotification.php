<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class IzinStatusNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $status; // Approved / Rejected

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'approval',
            'title' => 'Status Pengajuan Izin',
            'message' => 'Pengajuan izin Anda telah ' . strtolower($this->status),
            'status' => $this->status,
        ];
    }
}
