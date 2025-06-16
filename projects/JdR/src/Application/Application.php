<?php

namespace Application;

use Lib\ValueObject\PositiveInt;
use Module\Character\Model as Character;
use Module\Mj\Model as Mj;
use Module\Scenario\Factory\ScenarioFactory;       
use Module\Character\Factory\CharacterFactory;
use Module\Scenario\Model as Scenario;
use Module\Scenario\Strategy\DefaultResolutionStrategy;

class Application
{
    const DEFAULT_NB_RUNS = 1;

    protected Mj\GameMaster $mj;
    protected Character\Party $party;

    public function __construct(
        private string $dataDir
    ) {
        $this->mj = new class
        (
            new Mj\Deck(
                ['♦️','♥️','♠️','♣️'],
                [2,3,4,5,6,7,8,9,10,'V','Q','K',1]
            ),
            new Mj\Deck(
                ['⚽', '🎳', '🥌'],
                range(start: 1, end: 18, step: 1)
            ),
            new Mj\Dice(6),
            new Mj\Dice(10),
            new Mj\Dice(20),
            new Mj\Coin(4),
            new Mj\Coin(6)
        ) extends Mj\GameMaster {
            protected function announce(string $message)
            {
                echo $message . "\n";
            }
        };

        // Lecture des personnages via CharacterFactory
        $charactersData = json_decode(file_get_contents($this->dataDir . '/characters.json'), true);

        $this->party = new Character\Party(...array_map(
            fn($data) => CharacterFactory::create($data),
            $charactersData
        ));
    }

    public function run($script, ?int $nbRuns = self::DEFAULT_NB_RUNS)
    {
        try {
            var_dump($this->dataDir);

            $scenarioFactory = new ScenarioFactory(
                new \Lib\File\JsonFileDatastoreAdapter(
                    new \Lib\File\JsonFileReader($this->dataDir.'/scenarios.json')
                )
            );

            $strategy = new DefaultResolutionStrategy(); // 👈 stratégie choisie

            for ($i = 0; $i < $nbRuns; $i++) {
                $party = clone $this->party;  // Nouvelle Party à chaque run

                foreach ($scenarioFactory->createScenarios() as $scenario) {
                    echo (
                        $this->mj->entertain($party, $scenario, $strategy) ?
                            "\n>>> 🤘 Victory 🤘 <<<\n\n" :
                            "\n>>> 💀 Defeat 💀 <<<\n\n"
                    );
                }
            }

        } catch (\Throwable $e) {
            echo "❌ Une erreur est survenue : " . $e->getMessage() . "\n";
            debug_print_backtrace();
        }
    }
}
