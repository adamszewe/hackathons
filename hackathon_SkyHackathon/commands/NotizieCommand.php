<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/29/16
 * Time: 3:48 AM
 */
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use ContenderApps\CatalystBot\Acera;


class NotizieCommand extends Command
{
    protected $name = "notizie";

    protected $description = "ultime notizie relative alla squadra";

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
        $id = false;
        $team = "doggy";
        if (isset($from["id"])) {
            $id = intval($from["id"]);
            $team = $acera->getUserTeam($id);
        }
    

//        $team = "";
//        if (isset($from["id"])) {
//            $id = $from["id"];
//            $team = $this->getTeam($this->getUpdate());
//            if ($team === false) {
//                return;
//            } else {
//                if ($team === false) {
//                    $id = intval($id);
//                    $acera->upsertUserTeam($id, $team);
//                }
//            }
//        }
        
        
        
        

        
        $commands = [
            ["/calciomercato"],
            ["/infermeria"],
            ["/formazione"],
            ["/pagelle"],
            ["/squalificati"],
            ["/ultimora"],
            ["/statistiche"],
            ["/schedagiocatore"]
        ];
        
        
        $telegram = $this->getTelegram();



        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $commands,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);


        $this->replyWithMessage([
            'text' => '-----' , 
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



//    public function getUserId($update) {
//        $from = Utils::getFrom($update);
//        if (isset($from["id"])) {
//            return intval($from["id"]);
//        } else {
//            return false;
//        }
//
//    }
    
    
    
}
