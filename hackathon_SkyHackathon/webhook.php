<?php
namespace ContenderApps\CatalystBot;

/**
 * @author Adam Szewera
 */

error_reporting(-1);

include 'vendor/autoload.php';

include 'commands/StartCommand.php';
include 'commands/SquadraCommand.php';
include 'commands/NotizieCommand.php';
include 'commands/FormazioneCommand.php';
include 'commands/CalciomercatoCommand.php';
include 'commands/BetCommand.php';
include 'commands/Utils.php';

include 'Acera.php';

// namespaces
use ContenderApps\CatalystBot\Commands\BetCommand;
use ContenderApps\CatalystBot\Commands\CalciomercatoCommand;
use Telegram\Bot\Api;

use ContenderApps\CatalystBot\Commands\StartCommand;
use ContenderApps\CatalystBot\Commands\NotizieCommand;
use ContenderApps\CatalystBot\Commands\SquadraCommand;
use ContenderApps\CatalystBot\Commands\FormazioneCommand;
use ContenderApps\CatalystBot\Commands\Utils;


$config = include('config.php');
$telegram = new Api($config['api_key']);

try {
    $telegram->addCommand( new StartCommand() );
    
    $telegram->addCommand( new SquadraCommand() );
    
    $telegram->addCommand( new NotizieCommand() );
    
    $telegram->addCommand( new FormazioneCommand() );
    
    $telegram->addCommand( new CalciomercatoCommand() );
    
    $telegram->addCommand( new BetCommand() );
    
//    $telegram->addCommand( new () );
    
    
} catch (Exception $e) {
    // todo log the error message	
}

$telegram->commandsHandler(true);

/*  */
//$update     = $telegram->getWebhookUpdates();

//$message    = $update['message'];
//$user       = $message['from'];
//$userId     = $user['id'];

$updates = $telegram->getwebhookUpdates();


// todo if the message is not a command then interpret the message

if (isset($updates["message"])) {
    $message = $updates["message"];
    $fromId = $message["from"]["id"];
    
    if (strpos($message, '/') === false) {
        $telegram->sendMessage([
            'chat_id' => $fromId,
            'text' => 'that was not a command'
        ]);
    } else {
        // it's a command
    }
}




//$telegram->sendMessage(
//    [
//        "chat_id" => 65526521,
//        "text" => "debug..."
//    ]);

