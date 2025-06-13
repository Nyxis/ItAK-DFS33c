<?php

require_once __DIR__ . '/src/Personnage.php';
require_once __DIR__ . '/src/Equipement.php';
require_once __DIR__ . '/src/Lib/Datastore.php';
require_once __DIR__ . '/src/Lib/JsonFileReader.php';
require_once __DIR__ . '/src/Lib/JsonFileDatastoreAdapter.php';
require_once __DIR__ . '/src/Module/Scenario/ScenarioFactory.php';
require_once __DIR__ . '/src/Module/Scenario/Scenario.php';
require_once __DIR__ . '/src/Module/Scenario/ScenarioEncounter.php';
require_once __DIR__ . '/src/Module/Scenario/Result.php';

use Lib\JsonFileReader;
use Lib\JsonFileDatastoreAdapter;
use Module\Scenario\ScenarioFactory;

// Création du personnage
$perso = new Personnage("Hero");

// Équipement du personnage
$perso->equiper(new Equipement("Épée"));
$perso->equiper(new Equipement("Bouclier"));

// Création de la factory et chargement des scénarios
$factory = new ScenarioFactory(
    new JsonFileDatastoreAdapter(
        new JsonFileReader(__DIR__ . '/data/scenarios.json')
    )
);

$scenarios = $factory->createScenarios();

// Test du premier scénario
$scenario = $scenarios[0];
echo "Scénario : " . $scenario->getTitle() . "\n";

foreach ($scenario->getEncounters() as $encounter) {
    echo "\n" . $encounter->getDescription() . "\n";
    echo "Choix possibles :\n";
    foreach ($encounter->getChoices() as $choice) {
        echo "- " . $choice . "\n";
    }
}

// Affichage des stats du personnage
echo "\nStats du personnage :\n";
echo "Niveau : " . $perso->niveau . "\n";
echo "Points de vie : " . $perso->pv . "/" . $perso->pvMax . "\n";
echo "Puissance : " . $perso->getPuissance() . "\n";
