<?php
namespace ContenderApps\CatalystBot;

/**
 * @author Adam Szewera
 */

error_reporting(-1);

include 'vendor/autoload.php';
include 'Acera.php';
include 'config.php';

// commands
try {
    include 'commands/BroadcastCommand.php';
    include 'commands/HackadamCommand.php';
    include 'commands/PresentationCommand.php';
    include 'commands/SecretCommand.php';
    include 'commands/StartCommand.php';
    include 'commands/StatsCommand.php';
} catch (Exception $e) {

}

// namespaces
use ContenderApps\CatalystBot\Commands\BroadcastCommand;
use ContenderApps\CatalystBot\Commands\HackadamCommand;
use ContenderApps\CatalystBot\Commands\PresentationCommand;
use ContenderApps\CatalystBot\Commands\StartCommand;
use ContenderApps\CatalystBot\Commands\SecretCommand;
use ContenderApps\CatalystBot\Commands\StatsCommand;
use Telegram\Bot\Api;

$config     = include('config.php');
$telegram   = new Api($config['api_key']);

// load commands
try {
    $commands = array (
        new BroadcastCommand(),
        new HackadamCommand(),
        new PresentationCommand(),
        new SecretCommand(),
        new StartCommand(),
        new StatsCommand(),
    );
    foreach ($commands as $command) {
        $telegram->addCommand($command);
    }
    $telegram->commandsHandler(true);
} catch (Exception $e) {
//     todo: log the exception
}








/*  */
$update     = $telegram->getWebhookUpdates();
$message    = $update['message'];
$user       = $message['from'];
$userId     = $user['id'];

if (isset($message['text'])) {
    $text = $message['text'];
    if (substr($text, 0, 1) === "/") {
        // it is a command
    } else {
        try {
            $acera = new Acera();
            $telegram->sendMessage($userId, "I don't understand..");
        } catch (Exception $e) {
            // todo log exception
        }
    }
}
