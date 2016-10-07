<?php
namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class HackadamCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "hackadam";

    /**
     * @var string Command Description
     */
    protected $description = "A secret command that lists all of the available commands - that are also 'secret'  ";

    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        /* print the list of all available commands */
        $this->replyWithMessage('Hello! Welcome to our bot, Here are our available commands:');
        $this->replyWithChatAction(Actions::TYPING);
        $commands = $this->getTelegram()->getCommands();

        // Build the list
        $response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }
        // Reply with the commands list
        $this->replyWithMessage($response);
    }
}
