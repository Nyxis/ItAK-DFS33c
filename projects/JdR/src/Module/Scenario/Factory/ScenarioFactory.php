<?php

namespace Module\Scenario\Factory;

use Lib\Datastore;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Module\Scenario\Model\Result;
use Module\Scenario\Model\Scenario;

class ScenarioFactory
{
    public function __construct(
        private Datastore $datastore
    ) {}

    /**
     * @return Scenario[]
     */
    public function createScenarios(): array
    {
        $scenarios = [];

        foreach ($this->datastore->loadData() as $scenarioData) {
            $encounters = [];

            foreach ($scenarioData['encounters'] as $encounterData) {
                $results = [];

                foreach ($encounterData['results'] as $resultData) {
                    $results[] = new Result(
                        new \Lib\ValueObject\PositiveInt($resultData['probability']),
                        Outcome::from($resultData['outcome'])
                    );
                }

                $encounters[] = new Encounter(
                    $encounterData['title'],
                    $encounterData['flavor'],
                    ...$results // spread operator , acces au tableau
                );
            }

            $scenarios[] = new Scenario(
                $scenarioData['title'],
                ...$encounters // le spread operator pour passer les objets un par un
            );            
        }

        return $scenarios;
    }
}
