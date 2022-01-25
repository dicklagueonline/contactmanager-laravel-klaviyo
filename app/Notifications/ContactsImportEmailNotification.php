<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ContactsImportEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($content)
    {
        $this->content = $content;
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
            ->subject('Contacts Import Successfull.')
            ->greeting('Greetings!')
            ->line('Importing contacts has been successfully finished.')
            ->line('Import Details: ')
            ->line('File: ' . $this->content['file'])
            ->line('File Size: ' . $this->content['filesize'])
            ->line('Processed Rows: ' . $this->content['processed_rows'])
            ->line('Import Finished at ' . $this->content['finished_at'])
            ->line('Thank you for using our application!');
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
            'file' => $this->content['file'],
            'filesize' => $this->content['filesize'],
            'processed_rows' => $this->content['processed_rows'],
            'finished_at' => $this->content['finished_at']
        ];
    }
}
