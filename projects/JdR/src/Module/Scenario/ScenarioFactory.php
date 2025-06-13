<?php

namespace Module\Scenario;

class ScenarioFactory
{
    /**
     * @param string $jsonPath
     * @return Scenario[]
     */
    public static function loadFromJson(string $jsonPath): array
    {
        if (!file_exists($jsonPath)) {
            throw new \InvalidArgumentException("Fichier introuvable: $jsonPath");
        }

        $raw = file_get_contents($jsonPath);
        $data = json_decode($raw, true);

        if (!is_array($data)) {
            throw new \RuntimeException("Le fichier JSON est invalide ou vide.");
        }

        $scenarios = [];

        foreach ($data as $scenarioData) {
            $encounters = [];

            foreach ($scenarioData['encounters'] as $encounterData) {
                $results = [];

                foreach ($encounterData['results'] as $outcomeKey => $probability) {
                    $outcome = Outcome::from(strtolower($outcomeKey));
                    $results[] = new Result($probability, $outcome);
                }

                $encounters[] = new Encounter(
                    $encounterData['title'],
                    $encounterData['flavor'],
                    ...$results
                );
            }

            $scenarios[] = new Scenario($scenarioData['title'], ...$encounters);
        }

        return $scenarios;
    }
}
