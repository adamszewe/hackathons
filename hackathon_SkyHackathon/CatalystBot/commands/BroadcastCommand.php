<?php
namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use ContenderApps\CatalystBot\Acera;
use Telegram\Bot\Commands\Command;

class BroadcastCommand extends Command
{


    /**
     * @var string Command Name
     */
    protected $name = "broadcast";

    /**
     * @var string Command Description
     */
    protected $description = "sends a message to all the users that connected to this bot";


    protected $acera;

    public function __construct()
    {
        $this->acera = new Acera();
    }



    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        $message = $this->getUpdate()['message'];
        $message = substr($message, 2 + count($this->name));
        $allUsers = $this->acera->getAllUsers();
        $telegram = $this->getTelegram();
        foreach ($allUsers as $user) {
            $telegram->sendMessage($user['id'], $message);
        }
    }
}

