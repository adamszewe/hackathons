<?php
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class AtalantaCommand extends Command
{
    protected $name = "Atalanta";

    /**
     * @var string Command Description
     */
    protected $description = "Atlanta - la tua squadra del cuore";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

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
            'text' => 'Scegli la tua squadra preferita: (atalantacommand)',
            'reply_markup' => $reply_markup
        ]);
        
        
    }
}
