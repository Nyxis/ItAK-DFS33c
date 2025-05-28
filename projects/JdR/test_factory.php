<?php

require_once 'src/Module/Scenario/Scenario.php';
require_once 'src/Module/Scenario/Encounter.php';
require_once 'src/Module/Scenario/Result.php';
require_once 'src/Module/Scenario/Outcome.php';
require_once 'src/Module/Scenario/ScenarioFactory.php';

use Module\Scenario\ScenarioFactory;

$scenarios = ScenarioFactory::loadFromJson('data/scenarios.json');

foreach ($scenarios as $scenario) {
    echo "Scénario : {$scenario->name}\n";

    foreach ($scenario->play() as $encounter) {
        echo " - Rencontre : {$encounter->title}\n";
        echo "   > {$encounter->flavour}\n";

        foreach ($encounter->getResults() as $result) {
            echo "     * " . $result->outcome->value . " : " . $result->probabiliy . "%\n";
        }
    }

    echo "\n";
}



