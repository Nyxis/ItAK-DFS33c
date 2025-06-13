<?php

namespace Module\Scenario;

use Lib\Datastore;

class ScenarioFactory
{
    private Datastore $datastore;

    public function __construct(Datastore $datastore)
    {
        $this->datastore = $datastore;
    }

    public function createScenarios(): array
    {
        $data = $this->datastore->loadData();
        $scenarios = [];

        foreach ($data as $scenarioData) {
            $scenarios[] = $this->createScenario($scenarioData);
        }

        return $scenarios;
    }

    private function createScenario(array $data): Scenario
    {
        $encounters = [];
        foreach ($data['encounters'] as $encounterData) {
            $encounters[] = new ScenarioEncounter(
                $encounterData['description'],
                $encounterData['choices']
            );
        }

        return new Scenario(
            $data['title'],
            $encounters,
            new Result($data['result']['success'], $data['result']['failure'])
        );
    }
} 