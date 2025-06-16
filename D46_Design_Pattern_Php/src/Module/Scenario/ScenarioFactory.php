<?php

namespace Module\Scenario;

use Lib\Datastore;
use Module\Scenario\Scenario;
use Module\Scenario\ScenarioEncounter;
use Module\Scenario\Result;

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

    public function createScenario(array $data): Scenario
    {
        $encounters = [];
        foreach (($data['encounters'] ?? []) as $encounterData) {
            $encounters[] = new ScenarioEncounter(
                $encounterData['title'] . "\n" . $encounterData['flavor'],
                [
                    "Succès (" . ($encounterData['results']['success'] ?? 0) . "%)",
                    "Échec (" . ($encounterData['results']['failure'] ?? 0) . "%)",
                    "Échec critique (" . ($encounterData['results']['fumble'] ?? 0) . "%)"
                ]
            );
        }

        return new Scenario(
            $data['title'] ?? 'Sans titre',
            $encounters,
            new Result(
                $data['result']['success'] ?? '',
                $data['result']['failure'] ?? ''
            )
        );
    }
} 