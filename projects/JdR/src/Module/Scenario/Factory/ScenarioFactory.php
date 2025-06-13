<?php

namespace Module\Scenario\Factory;

use Module\Scenario\Model\Scenario;

class ScenarioFactory
{
    public function __construct(string $filePath)
    {
        /* complete me */
    }

    public function createScenario(/* ..... */) : Scenario
    {
        return new Scenario(/* ..... */);
    }

    public function createScenarios() : \Iterator
    {
        $scenariosData = [/* .... */];

        foreach ($scenariosData as $scenarioData) {
            yield $this->createScenario(/* ..... */);
        }
    }
}
