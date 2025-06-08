<?php

namespace Module\Scenario\Factory;

use Module\Scenario\Model\Result;
use Module\Scenario\Model\Scenario;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Lib\ValueObject\PositiveInt;

class ScenarioFactory
{
    private array $scenariosData;

    public function __construct(string $filePath)
    {
        $content = file_get_contents($filePath);
        $this->scenariosData = json_decode($content, true);
    }

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
        $scenariosData = $this->scenariosData;
        foreach ($scenariosData as $scenarioData) {
            yield $this->createScenario($scenarioData);
        }
    }
}
