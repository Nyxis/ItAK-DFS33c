<?php

namespace Application;

use Lib\ValueObject\PositiveInt;
use Module\Character\Model as Character;
use Module\Mj\Model as Mj;
use Module\Scenario\Factory\ScenarioFactory;
use Lib\File\File;
use Lib\JsonFileReader;

class Application
{
    const DEFAULT_NB_RUNS = 1;

    protected Mj\GameMaster $mj;
    protected Character\Party $party;

    public function __construct(
        private string $dataDir
    ) {
        $this->mj = new class(
            new Mj\Deck(
                ['♦️', '♥️', '♠️', '♣️'],
                [2, 3, 4, 5, 6, 7, 8, 9, 10, 'V', 'Q', 'K', 1]
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

        $this->party = new Character\Party(
            new Character\Character('🪓Gertrude', new PositiveInt(10)),
            new Character\Character('🔥Zehirmann', new PositiveInt(15), new PositiveInt(11)),
            new Character\Character('🗡️ Enoriel', new PositiveInt(15), new PositiveInt(11)),
            new Character\Character('⚔️ Wrandrall', new PositiveInt(10)),
        );
    }

    public function run(array $argv)
    {
        echo "Démarrage jeu ";
        try {
            // var_dump($this->dataDir);

            // $scenarioFile = $this->dataDir . '/scenarios.json';
            // $scenarioFactory = new ScenarioFactory(
            //     new JsonFileDatastoreAdapter(
            //         new JsonFileReader($scenarioFile)
            //     )
            // );
            $factory = new ScenarioFactory(
                new FileDatasource(
                    new File(this->dataDir . '/scenarios.json'),    
                    new JsonFileReader()
                )
            );
            $nbRuns = 1;

            for ($i = 0; $i < $nbRuns; $i++) {
                $party = clone $this->party;

                foreach ($factory->createScenarios() as $scenario) {
                    echo "Scénario en cours...\n";
                    echo (
                        $this->mj->entertain($party, $scenario) ?
                        "\n>>> 🤘 Victory 🤘 <<<\n\n" :
                        "\n>>> 💀 Defeat 💀 <<<\n\n"
                    );
                }
            }
        } catch (\Exception $exception) {
            echo "Erreur: " . $exception->getMessage() . "\n";
            echo "Fichier: " . $exception->getFile() . "\n";
            echo "Ligne: " . $exception->getLine();
        }
        
        debug_print_backtrace();
    }
}
