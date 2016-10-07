<?php
namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use ContenderApps\CatalystBot\Acera;
use Telegram\Bot\Commands\Command;

class PresentationCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "presentation";

    /**
     * @var string Command Description
     */
    protected $description = "used for the project presentation - instead of boring slides";


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
        sleep(1);
        $this->broadcast('Presentazione del progetto ACERA @ Politecnico di Torino');
        sleep(1);
        $this->broadcast('3...');
        sleep(1);
        $this->broadcast('2...');
        sleep(1);
        $this->broadcast('1...');
        sleep(1);

        $this->broadcast("ACERA e' un progetto transmediale...");


    }



    private function broadcast($message)
    {
        $allUsers = $this->acera->getAllUsers();
        $telegram = $this->getTelegram();
        foreach ($allUsers as $user) {
            $telegram->sendMessage($user['id'], $message);
        }
    }
}
