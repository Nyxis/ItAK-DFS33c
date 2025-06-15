<?php

namespace Module\Scenario\Factory;

use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Scenario;

class ScenarioFactory
{
    public function __construct(
        private Datasource $datasource
    ) {
    }

    public function createScenario(string $name, Encounter ...$encounters) : Scenario
    {
        return new Scenario($name, ...$encounters);
    }

    public function createScenarios() : \Iterator
    {
        foreach ($this->datasource->loadAll() as $scenarioData) {
            yield $this->createScenario(
                $scenarioData['title'],

                ...array_map(                       // Encounters
                    fn($encouterData) => new Encounter(
                        $encouterData['title'],
                        $encouterData['flavor'],

                        ...array_reduce(            // Results
                            array_keys($encouterData['results'])
                            function (array $results, string $outcomeStr) {
                                $results[] = new Result(
                                    new PositiveInt($encouterData['results'][$outcomeStr]),
                                    Outcome::from($outcomeStr)
                                );

                                return $results;
                            }
                            []
                        )
                    ),
                    $scenarioData['encounters']
                )
            );
        }
    }
}
