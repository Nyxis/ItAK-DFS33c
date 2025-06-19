<?php

namespace Module\Mj\Model;

use Module\Character\Model\Party;
use Module\Character\Model\Character;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Module\Scenario\Model\Scenario;
use Module\Scenario\Strategy\ResolutionStrategy;
use Lib\ValueObject\PositiveInt;

class GameMaster
{
    private array $gameAccessories;

    private Announcer $announcer;

    public function __construct(
        Announcer $announcer,
        GameAccessory ...$gameAccessories
    ) {
        $this->announcer = $announcer;
        $this->gameAccessories = $gameAccessories;
    }

    public function pleaseGiveMeACrit() : int
    {
        return $this->gameAccessories[array_rand($this->gameAccessories)]
            ->generateRandomPercentScore();
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

    public function entertain(
        Party $party,
        Scenario $scenario,
        ResolutionStrategy $strategy
    ) : bool {
        $this->announcer->announce((string) $party);

        foreach ($scenario->play() as $encounter) {
            $this->announcer->announce("\n" . $encounter);

            $tries = 0;
            $score = 0;
            $bonus = 0;

            do {
                $score = $this->play($party, $encounter) + $bonus;
                $outcome = $strategy->resolve($encounter, $score);

                $this->announcer->announce(sprintf(
                    "Tentative #%d (+%d%% 🧠) : 🎲%d > %s",
                    $tries + 1,
                    $bonus,
                    $score,
                    $outcome->toString()
                ));

                $this->applyOutcome($party, $outcome);

                $bonus += Encounter::EXPE_BUFF;
                $tries++;
            } while ($outcome === Outcome::FAILURE && $tries < Encounter::MAX_TRIES);
        }

        $this->announcer->announce((string) $party);

        return !$party->isWipedOut();
    }

    private function play(Party $party, Encounter $encounter): int
    {
        return $this->pleaseGiveMeACrit();
    }
}