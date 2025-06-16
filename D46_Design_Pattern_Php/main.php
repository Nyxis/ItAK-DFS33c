<?php

require_once __DIR__ . '/Personnage.php';
require_once __DIR__ . '/Equipement.php';
require_once __DIR__ . '/src/Lib/Datastore.php';
require_once __DIR__ . '/src/Lib/File.php';
require_once __DIR__ . '/src/Lib/FileReader.php';
require_once __DIR__ . '/src/Lib/JsonFileReader.php';
require_once __DIR__ . '/src/Lib/FileDatastore.php';
require_once __DIR__ . '/src/Module/Scenario/ScenarioFactory.php';
require_once __DIR__ . '/src/Module/Scenario/Scenario.php';
require_once __DIR__ . '/src/Module/Scenario/ScenarioEncounter.php';
require_once __DIR__ . '/src/Module/Scenario/Result.php';

use Lib\File;
use Lib\JsonFileReader;
use Lib\FileDatastore;
use Module\Scenario\ScenarioFactory;

// Création du personnage
$perso = new Personnage("Hero");

// Équipement du personnage
$perso->equiper(new Equipement("Épée"));
$perso->equiper(new Equipement("Bouclier"));

// Création de la factory et chargement des scénarios
$factory = new ScenarioFactory(
    new FileDatastore(
        new File(__DIR__ . '/../projects/JdR/data/scenarios.json'),
        new JsonFileReader()
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
