<?php
namespace ContenderApps\CatalystBot;
// todo namespace

use Telegram\Bot\Laravel\Facades\Telegram;

include 'vendor/autoload.php';
include 'Acera.php';

use Telegram\Bot\Api;

function sendResponse($result) {
    header('Content-type: application/json');
    $a = array ( 'result' => $result );
    echo json_encode($a);
}

if ( isset($_GET['code'])) {
    $config     = include('config.php');
    $telegram   = new Api($config['api_key']);
    $acera = new Acera();


    // todo clean the code
    #$code = $_POST['code'];
    $code = filter_var($_GET['code'], FILTER_SANITIZE_STRING);
    if ($acera->isCodeValid($code)) {
        sendResponse(true);
    } else {
        sendResponse(false);
    }
} else {
    sendResponse(false);
}


