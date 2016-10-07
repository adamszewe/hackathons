<?php
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class BetCommand extends Command
{
    protected $name = "bet4fun";
    // fixme - implement the command : finish bet and start the timer

    protected $description = "Scommetti crediti virtuali sulle partite";

    public function handle($arguments)
    {

        $keyboard = [
            ['Bologna - Palermo', '2.65', '3.15', '1.65', ],
            ['Torino - Milan', '1.65', '0.15', '3.65', ],
            ['Chievo - Inter', '1.65', '3.15', '0.65', ],
            ['Bologna - Palermo', '0.65', '1.5', '2.15', ],
            ['Bologna - Palermo', '2.65', '4.44', '3.35', ],
            ['Fine']
        ];
        
        
        $telegram = $this->getTelegram();

        $reply_markup = $telegram->replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ]);
        
        

        $this->replyWithMessage([
            'text' => 'Bet4Fun:',
            //	'reply_markup' => $reply_markup
            'reply_markup' => $reply_markup
        ]);
        
        
//        $this->replyWithMessage(['text' => 'Hello! Welcome to our bot, Here are our available commands:']);
        


        

    }
}
