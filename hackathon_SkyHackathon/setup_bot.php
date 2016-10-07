<?php
/**
 * @author Adam Szewera
 */

include 'vendor/autoload.php';

$config = require 'config.php';

$telegram = new \Telegram\Bot\Api($config['api_key']);

// clear the previous webhook
$result = $telegram->removeWebhook();

$url = 'https://' . $config['domain'] . '/SkyHackathon/webhook.php';
echo $url . PHP_EOL;
echo $config['certificate_path'];
echo PHP_EOL;

//$result = $telegram->setWebhook( [
	//'url' => $url, 
	//'certificate' => $config['certificate_path'] 
//]);

$response = $telegram->setWebhook([
    'url' => 'sky.liferunsonco.de/SkyHackathon/webhook.php',
    'certificate' => '/home/adamszewecp/www/sky/SkyHackathon/cert.pem'
]);

var_dump($response);


echo "set up";
