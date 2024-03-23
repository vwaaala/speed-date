<?php

namespace Bunker\LaravelSpeedDate\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VoteComplete extends Notification
{
    use Queueable;

    protected $users;
    protected $participant;
    /**
     * Create a new notification instance.
     */
    public function __construct($users, $participant)
    {
        $this->users = $users;
        $this->participant = $participant;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable): MailMessage
    {
        return (new MailMessage)->view('speed_date::email', ['users' => $this->users, 'participant' => $this->participant]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
