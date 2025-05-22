<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\Models\GameMaster;
use App\Models\Scenario;
use App\Models\Encounter;

// Création du Game Master
$gameMaster = new GameMaster();

// Création du scénario
$scenario = new Scenario($gameMaster);

// Ajout des rencontres avec différentes difficultés
$scenario->addEncounter(new Encounter("Gobelin", 0.8));    // Plus facile
$scenario->addEncounter(new Encounter("Orc", 1.0));        // Normal
$scenario->addEncounter(new Encounter("Troll", 1.2));      // Plus difficile
$scenario->addEncounter(new Encounter("Dragon", 1.5));     // Très difficile
$scenario->addEncounter(new Encounter("Boss Final", 2.0)); // Extrêmement difficile

// Lancement du scénario
$success = $scenario->run();

// Affichage du résultat
echo $success 
    ? "Félicitations ! Le groupe a survécu au scénario !\n" 
    : "Game Over... Le groupe n'a pas survécu au scénario.\n"; 