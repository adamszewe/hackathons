<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/29/16
 * Time: 7:25 AM
 */



namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use ContenderApps\CatalystBot\Acera;


class CalciomercatoCommand extends Command
{
    protected $name = "calciomercato";

    protected $description = "Comando che inizializza la tua interazione con il bot";

    public function handle($arguments)
    {
        
        // check the team
        $info = "Calciomercato ATALANTA: Si parla di Leonardo Morosini in Serie A. Il centrocampista classe 1995 del Brescia è finito nel mirino del dell'Atalanta. Attente sul giocatore anche Bologna,Napoli e Juventus, due big che potrebbero decidere di prelevarlo dal Brescia per poi magari mandarlo in prestito consentendogli così di giocare con continuità.";

        $this->replyWithMessage([
            'text' => $info,
        ]);
    }




}
