<?php

require_once 'src/Module/Scenario/Scenario.php';
require_once 'src/Module/Scenario/Encounter.php';
require_once 'src/Module/Scenario/Result.php';
require_once 'src/Module/Scenario/Outcome.php';
require_once 'src/Module/Scenario/ScenarioFactory.php';

use Module\Scenario\ScenarioFactory;

$scenarios = ScenarioFactory::loadFromJson('data/scenarios.json');

foreach ($scenarios as $scenario) {
    echo "🎲 Scénario : {$scenario->name}\n\n";

    foreach ($scenario->play() as $encounter) {
        echo " - Rencontre : {$encounter->title}\n";
        echo "   > {$encounter->flavour}\n";

        $score = rand(0, 100);

        $outcome = $encounter->resolve($score);

        echo "   🎯 Score tiré : $score\n";
        echo "   ✅ Résultat : " . strtoupper($outcome->value) . "\n\n";
    }

    echo str_repeat("-", 40) . "\n\n";
}



