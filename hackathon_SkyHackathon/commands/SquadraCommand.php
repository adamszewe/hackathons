<?php
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use ContenderApps\CatalystBot\Acera;
use ContenderApps\CatalystBot\Commands\Utils;


class SquadraCommand extends Command
{
    protected $name = "Squadra";

    protected $description = "Squadra";
    
    protected $team = false;

    public function handle($arguments)
    {
        
        $acera = new Acera();
        $update = $this->getUpdate();
        $message = $update["message"];
        $from = $message["from"];
        $firstName = "";
        if ($from["first_name"]) {
            $firstName = $from["first_name"] . ", ";
        }

        $team = "";
        if (isset($from["id"])) {
            $id = $from["id"];
            $team = $this->getTeam($this->getUpdate());
            if ($team === false) {
                return;
            } else {
                if ($team === false) {
                    $id = intval($id);
                    $acera->upsertUserTeam($id, $team);
                }
            }
        }


        $commands = [
            ["/notizie - notizie"],
            ["/social - social"]
        ];
        

        $telegram = $this->getTelegram();
        

        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $commands,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
        

        $this->replyWithMessage([
            'text' => 'Squadra: ' . $team,
            'reply_markup' => $reply_markup
        ]);



    }
    
    
    
    public function getTeam($update) {
        if (isset($update["message"])) {
            $message = $update["message"];
            if (isset($message["text"])) {
                $commandTeam = explode('-', $message["text"]);
                $team = trim($commandTeam[1]);
                return $team;
            } 
        }
        return false;
    }
    
    
    
    public function getUserId($update) {
        $from = Utils::getFrom($update);
        if (isset($from["id"])) {
            return $from["id"];
        } else {
            return false;
        }
        
    }
    
    
    
    
    
}
