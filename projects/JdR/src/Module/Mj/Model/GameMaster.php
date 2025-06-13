<?php

namespace Module\Mj\Model;

use Module\Character\Model\Character;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Module\Scenario\Model\Scenario;
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
    }

    public function pleaseGiveMeACrit() : int
    {
        // select a random game accessory
        return $this->gameAccessories[array_rand($this->gameAccessories)]
            ->generateRandomPercentScore()
        ;
    }

    private function applyOutcome(Character $character, Outcome $outcome) : bool
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

    public function entertain(Character $character, Scenario $scenario) : bool
    {
        $this->announce($character);

        foreach ($scenario->play() as $encounter) {
            if (!$character->isAlive()) {
                return false;
            }

            $this->announce("\n".$encounter);

            $isSuccess = false;
            for ($currentTry = 0; $character->isAlive() && !$isSuccess; $currentTry++) {
                $outcome = $encounter->resolve(
                    $score = $this->pleaseGiveMeACrit() + $currentTry * Encounter::EXPE_BUFF
                );

                $this->announce(sprintf('Tentative #%d (+%d%% 🧠) : 🎲%d > %s',
                    $currentTry + 1,
                    $currentTry * Encounter::EXPE_BUFF,
                    $score,
                    $outcome->toString()
                ));

                $isSuccess = $this->applyOutcome($character, $outcome);

                // too much failures : hurt character badly
                if (!$isSuccess && $currentTry + 1 >= Encounter::MAX_TRIES) {
                    $character->hurt(new PositiveInt($currentTry * 2));
                }

                $this->announce($character);
            }
        }

        return true;
    }
}
