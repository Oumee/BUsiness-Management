<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class devis extends Notification
{
    use Queueable;
    private $id_devis;
    private $update;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id_devis,$update)
    {
        $this->id_devis = $id_devis;
        $this->update = $update;
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
        $url = 'http://127.0.0.1:8000/show_devis/'.$this->id_devis;
        return (new MailMessage)
                    ->subject('Devis')
                    ->greeting('Bonjour')
                    ->line('Madame/Monsieur ')
                    ->action('Vous pouvez consulté votre devis via le lien ',  $url)
                    ->line('Merci pour votre attention')
                    ->line('Pour toute Information vous pouvez nous contactez ')
                    ->line('N Téléphone : +212675228162 ');   
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
