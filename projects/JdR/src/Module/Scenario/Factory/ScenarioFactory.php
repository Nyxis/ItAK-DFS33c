<?php

namespace Module\Scenario\Factory;

use Lib\Datastore;
use Module\Scenario\Model\Scenario;
use Module\Scenario\Model\Encounter;

class ScenarioFactory
{
    private Datastore $datastore;

    public function __construct(Datastore $datastore)
    {
        $this->datastore = $datastore;
    }

    public function createScenario(array $data) : Scenario
    {
        $encounters = array_map(
            fn(array $encounterData) => new Encounter(
                $encounterData['description'] ?? '',
                $encounterData['difficulty'] ?? 0
            ),
            $data['encounters'] ?? []
        );

        return new Scenario(
            $data['name'] ?? 'Unnamed Scenario',
            ...$encounters
        );
    }

    public function createScenarios() : \Iterator
    {
        $scenariosData = $this->datastore->loadData();

        foreach ($scenariosData as $scenarioData) {
            yield $this->createScenario($scenarioData);
        }
    }
}
