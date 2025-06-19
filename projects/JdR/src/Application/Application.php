<?php

namespace Application;

use Lib\ValueObject\PositiveInt;
use Module\Character\Model as Character;
use Module\Mj\Model as Mj;
use Module\Scenario\Factory\ScenarioFactory;
use Module\Character\Factory\CharacterFactory;
use Module\Scenario\Model as Scenario;
use Module\Scenario\Strategy\DefaultResolutionStrategy;

use Module\Mj\Model\EchoAnnouncer; // 👈 Ajouté

class Application
{
    const DEFAULT_NB_RUNS = 1;

    protected Mj\GameMaster $mj;
    protected Character\Party $party;

    public function __construct(
        private string $dataDir
    ) {
        // ✅ GameMaster avec EchoAnnouncer
        $this->mj = new Mj\GameMaster(
            new EchoAnnouncer(), // 👈 injection de l'annonceur
            new Mj\Deck(['♦️', '♥️', '♠️', '♣️'], [2, 3, 4, 5, 6, 7, 8, 9, 10, 'V', 'Q', 'K', 1]),
            new Mj\Deck(['⚽', '🎳', '🥌'], range(1, 18)),
            new Mj\Dice(6),
            new Mj\Dice(10),
            new Mj\Dice(20),
            new Mj\Coin(4),
            new Mj\Coin(6)
        );

        // Lecture des personnages via CharacterFactory
        $charactersData = json_decode(file_get_contents($this->dataDir . '/characters.json'), true);

        $factory = new CharacterFactory();
        $this->party = new Character\Party(...array_map(
            fn($data) => $factory->create($data),
            $charactersData
        ));
    }

    public function run($script, ?int $nbRuns = self::DEFAULT_NB_RUNS)
    {
        try {
            var_dump($this->dataDir);

            $scenarioFactory = new ScenarioFactory(
                new \Lib\File\JsonFileDatastoreAdapter(
                    new \Lib\File\JsonFileReader($this->dataDir . '/scenarios.json')
                )
            );

            $strategy = new DefaultResolutionStrategy();

            for ($i = 0; $i < $nbRuns; $i++) {
                $party = clone $this->party;

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
