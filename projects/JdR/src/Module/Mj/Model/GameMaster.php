<?php

namespace Module\Mj\Model;

use Module\Character\Model\Party;
use Module\Character\Model\Character;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Module\Scenario\Model\Scenario;
use Module\Scenario\Strategy\ResolutionStrategy;

use Lib\ValueObject\PositiveInt;

/**
 * The Game master class, using various GameAccessories to give results to users.
 */
class GameMaster
{
    private array $gameAccessories;

    public function __construct(
        GameAccessory ...$gameAccessories
    ) {
        $this->gameAccessories = $gameAccessories;
    }

    protected function announce(string $message)
    {
        echo $message . "\n";
    }

    public function pleaseGiveMeACrit(): int
    {
        // select a random game accessory
        return $this->gameAccessories[array_rand($this->gameAccessories)]
            ->generateRandomPercentScore();
    }

    private function applyOutcome(Character $character, Outcome $outcome): bool
    {
        switch ($outcome) {
            case Outcome::FUMBLE:
                $character->kill();
                return false;

            case Outcome::FAILURE:
                $character->hurt();
                return false;

            case Outcome::SUCCESS:
                $character->levelUp();
                return true;

            case Outcome::CRITICAL:
                $character->levelUp();
                $character->heal();
                return true;
        }
    }

    public function entertain(
        Party $party,
        Scenario $scenario,
        ResolutionStrategy $strategy
    ): bool {
        echo $party . "\n";

        foreach ($scenario->getEncounters() as $encounter) {
            echo "\n" . $encounter . "\n";

            $tries = 0;
            $score = 0;
            $bonus = 0;

            do {
                $score = $this->play($party, $encounter) + $bonus;
                $outcome = $strategy->resolve($encounter, $score);

                echo sprintf(
                    "Tentative #%d (+%d%% 🧠) : 🎲%d > %s\n",
                    $tries + 1,
                    $bonus,
                    $score,
                    $outcome->toString()
                );

                foreach ($party->members() as $character) {
                    if (!$character->isAlive()) continue;

                    $this->applyOutcome($character, $outcome);
                }

                $bonus += Encounter::EXPE_BUFF;
                $tries++;
            } while ($outcome === Outcome::FAILURE && $tries < Encounter::MAX_TRIES);
        }

        echo $party . "\n";

        return !$party->isWipedOut();
    }

    private function play(Party $party, Encounter $encounter): int
    {
        return $this->pleaseGiveMeACrit();
    }
}
