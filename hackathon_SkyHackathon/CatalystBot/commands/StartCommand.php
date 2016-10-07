<?php
namespace ContenderApps\CatalystBot\Commands;
/**
 * @author Adam Szewera
 */

use ContenderApps\CatalystBot\Acera;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;

class StartCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "start";

    /**
     * @var string Command Description
     */
    protected $description = "Start Command to get you started";


    protected $acera;

    public function __construct()
    {
        try {
            $this->acera = new Acera();
        } catch (Exception $e) {
            // todo manage this exception
        }
    }


    /**
     * @inheritdoc
     */
    public function handle($arguments)
    {
        try {
            $update = $this->getUpdate();
            $user = $update['message']['from'];
            $userId = $user['id'];

            /* if the user is already registered, then skip this step */
            if ($this->acera->isUser($userId) === false) {
                // then, add the user to the database
                $this->acera->addUser($userId, $user['first_name'], $user['last_name'], $user['username']);
            }



            $message = "Ciao " . $user['first_name'] . PHP_EOL;
            $this->replyWithMessage($message);
            $message = "Questo e' un bot che fa parte del progetto ACERA";
            $this->replyWithMessage($message);
        } catch (Exception $e) {
            // todo manage this exception
        }

    }
}