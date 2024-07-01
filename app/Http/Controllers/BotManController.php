<?php
namespace App\Http\Controllers;

use BotMan\BotMan\BotMan;
use BotMan\BotMan\Messages\Incoming\Answer;
use Illuminate\Http\Request;
use BotMan\BotMan\Messages\Outgoing\OutgoingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use App\Played;
use App\Highcore;
use BotMan\BotMan\Messages\Conversations\Conversation;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->hears('{message}', function($botman, $message) {
            // Convertir le message en minuscule pour les comparaisons
            $message = strtolower($message);
            
            if (in_array($message, ['bonjour', 'salut', 'salam', 'bonsoir'])) {
                // Utiliser une fermeture pour accéder à la méthode askName
                $this->askName($botman);
            } else {
                // Répondre avec le message reçu
                $botman->reply('Qu\'est ce que vous voulez dire par '.$message);
            }
      
        });

        $botman->listen();
    }

    /**
     * Place your BotMan logic here.
     */
    public function askName($botman)
    {
        $botman->ask('Bonjour, Qu\'est ce que vous voulez comme information ?', function(Answer $answer) {
            $name = $answer->getText();
            $message = strtolower($name);

            if (in_array($message, ['factures', 'facture', 'payement', 'je veux savoir les factures'])) {
                $this->say('Pour consulter l\'ensemble des factures vous pouvez consulter le lien : http://127.0.0.1:8000/factures');
            } 
            if (in_array($message, ['client', 'clients', 'customer', 'je veux savoir les clients'])) {
                $this->say('Pour consulter l\'ensemble des clients vous pouvez consulter le lien : http://127.0.0.1:8000/clients');
            }
            if (in_array($message, ['user', 'utilisateur', 'utilisateurs', 'je veux savoir les utilisateurs'])) {
                $this->say('Pour consulter l\'ensemble des factures vous pouvez consulter le lien : http://127.0.0.1:8000/users');
            }
            if (in_array($message, ['devis', 'devi', 'payement', 'je veux savoir les devis'])) {
                $this->say('Pour consulter l\'ensemble des devis vous pouvez consulter le lien : http://127.0.0.1:8000/devis');
            } 
            if (in_array($message, ['produit', 'produits', 'product', 'je veux savoir les produits'])) {
                $this->say('Pour consulter l\'ensemble des produits vous pouvez consulter le lien : http://127.0.0.1:8000/products');
            } 
            if (in_array($message, ['fournisseurs', 'fournisseur', 'provider', 'je veux savoir les fournisseurs'])) {
                $this->say('Pour consulter l\'ensemble des fournisseurs vous pouvez consulter le lien : http://127.0.0.1:8000/fournisseurs');
            }
             if (in_array($message, ['entreprises', 'entreprise', 'company', 'je veux savoir les entreprises'])) {
                $this->say('Pour consulter l\'ensemble des entreprises vous pouvez consulter le lien : http://127.0.0.1:8000/entreprises');
            }
      
        });
    }
}
