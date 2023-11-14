<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExtraBudgetApprovalRequest extends Notification
{
    use Queueable;

    public $projectName;
    public $projectSlug;
    public $budgetTitle;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($projectName, $projectSlug, $budgetTitle)
    {
        $this->projectName = $projectName;
        $this->projectSlug = $projectSlug;
        $this->budgetTitle = $budgetTitle;
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
            ->line('This is a request to approve a supplementary budget for ' . $this->projectName)
            ->line('The supplementary budget is titled - '. $this->budgetTitle)
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
