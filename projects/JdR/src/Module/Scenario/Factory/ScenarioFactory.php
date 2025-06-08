<?php

namespace Module\Scenario\Factory;

use Module\Scenario\Model\Result;
use Module\Scenario\Model\Scenario;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Lib\ValueObject\PositiveInt;
use Lib\DataStore;

class ScenarioFactory
{
    public function __construct(
        private Datastore $datastore
    ) {}

    public function createScenario(array $data): Scenario
    {
        $encounters = [];

        foreach ($data['encounters'] as $encounterData) {
            $results = [];

            foreach ($encounterData['results'] as $outcome => $probability) {
                $results[] = new Result(
                    new PositiveInt($probability),
                    Outcome::from($outcome)
                );
            }
            $encounters[] = new Encounter(
                $encounterData['title'],
                $encounterData['flavor'],
                ...$results
            );
        }
        return new Scenario($data['title'], ...$encounters);
    }

    public function createScenarios(): \Iterator
    {
        //Recup datas à l'interface
        $scenariosData = $this->datastore->loadData();
        foreach ($scenariosData as $scenarioData) {
            yield $this->createScenario($scenarioData);
        }
    }
}
