<?php
namespace ContenderApps\CatalystBot;

error_reporting(-1);

/**
 * @author Adam Szewera
 */

error_reporting(-1);

include 'vendor/autoload.php';
include 'config.php';

// commands

// namespaces
use Telegram\Bot\Api;

$config     = include('config.php');
$telegram   = new Api($config['api_key']);



$response = $telegram->getMe();

$botId = $response->getId();
$firstName = $response->getFirstName();
$username = $response->getUsername();

var_dump($response);
echo $botId;


