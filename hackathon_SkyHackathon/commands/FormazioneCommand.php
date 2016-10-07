<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/29/16
 * Time: 4:16 AM
 */
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class FormazioneCommand extends Command
{
    protected $name = "formazione";

    protected $description = "scopri la formazione della squadra";

    public function handle($arguments)
    {

        $this->replyWithPhoto([
            'photo' => 'formazione.jpg',
            'caption' => "Formazione della squadra"
        ]);
        
        
        $telegram = $this->getTelegram();
        $telegram->replyKeyboardHide();


    }
}
