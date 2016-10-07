<?php
namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use ContenderApps\CatalystBot\Acera;
use Telegram\Bot\Commands\Command;

class SecretCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "secret";

    /**
     * @var string Command Description
     */
    protected $description = "A secret command to generate a secret pass code for accessing special content";

    /**
     * Database access
     */
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
        $update = $this->getUpdate();
        $user = $update['message']['from'];
        $userId = $user['id'];

        $code = $this->acera->generateCode();
        $this->acera->addSecretCode($code, $userId, time());

        $response = "Il tuo codice segreto e': " . PHP_EOL;
        $this->replyWithMessage($response);
	$this->replyWithMessage($code);


    }
}
