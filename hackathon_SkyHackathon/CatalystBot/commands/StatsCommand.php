<?php
namespace ContenderApps\CatalystBot\Commands;

/**
 * @author Adam Szewera
 */

use ContenderApps\CatalystBot\Acera;
use Telegram\Bot\Commands\Command;

class StatsCommand extends Command
{
    /**
     * @var string Command Name
     */
    protected $name = "stats";

    /**
     * @var string Command Description
     */
    protected $description = "provides statistics about the bot usage and its users";

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
        // sends statistics about users
        $this->replyWithMessage($this->acera->stats());
    }
}