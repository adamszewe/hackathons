<?php
/**
 * Created by PhpStorm.
 * User: adam
 * Date: 5/29/16
 * Time: 9:07 AM
 */


$teams = [
    ["/Atalanta - Atalanta"],
    ["/Bologna - Bologna"],
    ["/Cagliari - Cagliari"],
    ["/Chievo - Chievo"],
    ["/Crotone - Crotone"],
    ["/Empoli - Empoli"],
    ["/Fiorentina - Fiorentina"],
    ["/Genoa - Genoa"],
    ["/Inter - Inter"],
    ["/Juventus - Juventus"],
    ["/Lazio - Lazio"],
    ["/Milan - Milan"],
    ["/Napoli - Napoli"],
    ["/Palermo - Palermo"],
    ["/Roma - Roma"],
    ["/Sampdoria - Sampdoria"],
    ["/Sassuolo - Sassuolo"],
    ["/Torino - Torino"],
    ["/Udinese - Udinese"]
];

foreach ($teams as $team) {
    $tt = $team[0];
    $commandTeam = explode('-', $tt);
    echo $commandTeam[0] . "     " . $commandTeam[1] . PHP_EOL;
    
    
}
