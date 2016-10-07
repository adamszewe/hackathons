<?php
namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use ContenderApps\CatalystBot\Acera;


class StartCommand extends Command
{
    protected $name = "start";

    protected $description = "Comando che inizializza la tua interazione con il bot";

    public function handle($arguments)
    {
        $teams = [
            ["/Squadra - Atalanta"],
            ["/Squadra - Bologna"],
            ["/Squadra - Cagliari"],
            ["/Squadra - Chievo"],
            ["/Squadra - Crotone"],
            ["/Squadra - Empoli"],
            ["/Squadra - Fiorentina"],
            ["/Squadra - Genoa"],
            ["/Squadra - Inter"],
            ["/Squadra - Juventus"],
            ["/Squadra - Lazio"],
            ["/Squadra - Milan"],
            ["/Squadra - Napoli"],
            ["/Squadra - Palermo"],
            ["/Squadra - Roma"],
            ["/Squadra - Sampdoria"],
            ["/Squadra - Sassuolo"],
            ["/Squadra - Torino"],
            ["/Squadra - Udinese"]
        ];
        
        $telegram = $this->getTelegram();

        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $teams,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);

        $update = $this->getUpdate();
        $message = $update["message"];
        $from = $message["from"];
        $firstName = "";
        if ($from["first_name"]) {
            $firstName = $from["first_name"] . ", ";
        }
        
        $this->replyWithMessage([
            'text' => $firstName . 'scegli la squadra:',
            'reply_markup' => $reply_markup
        ]);
    }
    
}
