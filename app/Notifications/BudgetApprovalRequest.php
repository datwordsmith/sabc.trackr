<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BudgetApprovalRequest extends Notification
{
    use Queueable;

    public $projectName;
    public $projectSlug;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($projectName, $projectSlug)
    {
        $this->projectName = $projectName;
        $this->projectSlug = $projectSlug;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Request for Budget Approval - ' . $this->projectName)
            ->line('This is a request to approve the budget for ' . $this->projectName)
            ->action('View Budget', url('t/project/' . $this->projectSlug))
            ->line('Thank you for using Trackr!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
