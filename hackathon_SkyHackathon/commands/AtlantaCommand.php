<?php
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;


class AtlantaCommand extends Command
{
    protected $name = "Atlanta";

    /**
     * @var string Command Description
     */
    protected $description = "Atlanta - la tua squadra del cuore";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {

        $this->replyWithMessage( [
            'text' => 'Scegli la tua squadra preferita: '
        ]);

        $teams = [
            "notizie",
            "social",
        ];
        $respString = "";
        foreach ($teams as $team) {
            $respString .= '/' . $team . PHP_EOL . PHP_EOL;
        }
        $this->replyWithMessage( [
            'text' => $respString
        ]);


//
//        $this->replyWithChatAction(['action' => Actions::TYPING]);
//
//        $commands = $this->getTelegram()->getCommands();
//        
//        // todo scegli la tua squadra
//
//        $response = '';
//        foreach ($commands as $name => $command) {
//            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
//        }
//
//        $this->replyWithMessage(['text' => $response]);

    }
}
