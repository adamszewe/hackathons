<?php 
namespace ContenderApps\CatalystBot;

include 'Acera.php';

$acera = new Acera();
echo "user team: " . var_dump($acera) . PHP_EOL;


//$acera->updateBetCredits(123, 1000);
//$acera->updateCredits(777, 900);
//$acera->updateBet(777, 800);


$acera->upsertBet(444, 9);

$credits = $acera->getCredits(444);
$betCredits = $acera->getBetCredits(444);
echo "credits: " . $credits . PHP_EOL;
echo "bet credits: " . $betCredits . PHP_EOL;
















