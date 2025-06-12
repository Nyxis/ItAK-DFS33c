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
    //Modif pour découplage 
    public function __construct(
        private Datastore $datastore
    ) {}

    public function createScenario(array $data): Scenario
    {
        $encounters = [];
        //Result pour chaque encounter
        foreach ($data['encounters'] as $encounterData) {
            $results = [];
            //Boucle sur tableau de results avec probabilité
            foreach ($encounterData['results'] as $outcome => $probability) {
                $results[] = new Result(
                    new PositiveInt($probability),
                    Outcome::from($outcome)
                );
            }
            //Ajout titre, descrpt et result au tableau
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
        //Recup. datas
        $scenariosData = $this->datastore->loadData();
        foreach ($scenariosData as $scenarioData) {
            yield $this->createScenario($scenarioData);
        }
    }
}
