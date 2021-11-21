<?php

namespace App\Notifications\Postulaciones;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PostulacionActualizada extends Notification
{
    use Queueable;

    public function __construct($postulacion)
    {
        $this->postulacion = $postulacion;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage())
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'postulacion' => $this->postulacion,
        ];
    }
}
