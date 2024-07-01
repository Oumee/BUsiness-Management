<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;


class facture extends Notification
{
    use Queueable;
    private $id_facture;
    private $update;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id_facture,$update)
    {
        $this->id_facture = $id_facture;
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
        DB::beginTransaction();

           $url = 'http://127.0.0.1:8000/show/'.$this->id_facture;
            return (new MailMessage)
                        ->subject('Modification Facture')
                        ->greeting('Bonjour')
                        ->action('Vous pouvez consulté votre facture via le lien ',  $url)
                        ->line('Merci pour votre attention')
                        ->line('Pour toute Information vous pouvez nous contactez ')
                        ->line('N Téléphone : +212675228162 ');   
       
       
        DB::commit();
        echo ';f;f;f';      
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
