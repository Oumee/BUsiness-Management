<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\factures;
use Illuminate\Support\Facades\Auth;


class AlertNotification extends Notification
{
    use Queueable;
    private $id_facture;
     /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($id_facture)
    {
       $this->id_facture = $id_facture;
     }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
     
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */

    public function toDatabase($notifiable)
    {
        $url = 'http://127.0.0.1:8000/show/'.$this->id_facture;
        return [
            'id'=> $this->id_facture,
            'title'=> 'Factures a bien été ajoutée',
            'user'=>   Auth::user()->name,       
            'action'=>   $url,       
         ];
    }

}
