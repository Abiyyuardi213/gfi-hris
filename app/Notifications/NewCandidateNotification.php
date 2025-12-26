<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCandidateNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $candidate;

    public function __construct($candidate)
    {
        $this->candidate = $candidate;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'type' => 'info',
            'title' => 'Pendaftar Baru',
            'message' => 'Kandidat baru mendaftar: ' . $this->candidate->name,
            'status' => 'Info',
            'url' => route('recruitment.admin.index') // We will create this route
        ];
    }
}
