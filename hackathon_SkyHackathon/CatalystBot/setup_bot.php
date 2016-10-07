<?php
/**
 * @author Adam Szewera
 */

include 'vendor/autoload.php';

$config = require 'config.php';

$telegram = new \Telegram\Bot\Api($config['api_key']);

// clear the previous webhook
$result = $telegram->removeWebhook();

$url = 'https://' . $config['domain'] . '/CatalystBot/webhook.php';
$result = $telegram->setWebhook( $url, $config['certificate_path'] );

echo "set up";
