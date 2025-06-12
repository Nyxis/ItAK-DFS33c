<?php

namespace Module\Scenario\Factory;

use Module\Scenario\Model\Scenario;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Result;
use Module\Scenario\Model\Outcome;
use Lib\ValueObject\PositiveInt;
use Lib\Datastore;

class ScenarioFactory
{
    public function __construct(
        private Datastore $datastore
    ) {
    }

    public function createScenario(array $scenarioData) : Scenario
    {
        $encounters = [];
        
        foreach ($scenarioData['encounters'] as $encounterData) {
            $results = [];
            
            foreach ($encounterData['results'] as $outcomeType => $probability) {
                $outcome = match($outcomeType) {
                    'fumble' => Outcome::FUMBLE,
                    'failure' => Outcome::FAILURE,
                    'success' => Outcome::SUCCESS,
                    'critical' => Outcome::CRITICAL,
                    default => throw new \InvalidArgumentException("Unknown outcome type: {$outcomeType}")
                };
                
                $results[] = new Result(
                    new PositiveInt($probability),
                    $outcome
                );
            }
            
            $encounters[] = new Encounter(
                $encounterData['title'],
                $encounterData['flavor'],
                ...$results
            );
        }
        
        return new Scenario($scenarioData['title'], ...$encounters);
    }

    public function createScenarios() : \Iterator
    {
        $scenariosData = $this->datastore->loadData();
        
        foreach ($scenariosData as $scenarioData) {
            yield $this->createScenario($scenarioData);
        }
    }
}
