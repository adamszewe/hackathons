<?php
namespace ContenderApps\CatalystBot;
//todo add namespace

error_reporting(E_ALL);


include 'vendor/autoload.php';
$config = include 'config.php';
include 'Acera.php';

use Telegram\Bot\Api;

// get the unique code
// find out the user who sent it
// send the link to the youtube video to the user

if (isset($_GET['usercode'])) {

    $acera = new Acera();
    $telegram   = new Api($config['api_key']);

    $code = $_GET['usercode'];
    $userId = $acera->codeToUser("$code");
    echo "ok the user's code is: " . $userId . "<br />";
    if ($userId !== false) {
        // send the video link to the user
        // video link:
	$message = "Mi e' stato detto di contattarti tramite questa linea sicura. Mi chiamo Celeste e ho urgenza di recuperare una fotografia molto importante per me prima che sia troppo tardi!!";
	$message .= "John dell'ACERA Group dice che la chiave risolutiva del problema risiede in questo video: ";
        $telegram->sendMessage($userId, $message);
        $telegram->sendMessage($userId, 'http://youtu.be/miCmS6h33Dw');

	$message = "Puoi aiutarmi a decifrarlo per accedere alla  soluzione ? " . PHP_EOL . "Grazie mille!!";
        $telegram->sendMessage($userId, $message);
        $telegram->sendMessage($userId, 'Vai alla pagina:  http://acera.liferunsonco.de/ipdialog.html      per inserire il codice');
    }
}

