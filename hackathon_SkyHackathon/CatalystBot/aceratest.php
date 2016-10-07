<?php 
namespace ContenderApps\CatalystBot;

include 'Acera.php';

$acera = new Acera();
echo var_dump($acera);

//$acera->addSecretCode('1a2b3c', 77, time());

#$a = '1a2b3c';
#echo filter_var( $a, FILTER_SANITIZE_STRING);

$userid = $acera->codeToUser('9b38c1');
echo $userid;

