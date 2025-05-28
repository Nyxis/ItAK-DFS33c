<?php

namespace Module\Scenario;

/**
 * A representation of an Encounter in an RPG
 */
class Encounter
{
    const MAX_TRIES = 2;
    const EXPE_BUFF = 15;

    /**
     * @var Result[]
     */
    private array $resultLadder;

    public function __construct(
        public readonly string $title,
        public readonly string $flavour,
        Result ...$resultLadder
    ) {
        $this->resultLadder = $resultLadder;
    }

    public function resolve(int $score) : Outcome
    {
        if ($score >= 100) {
            return Outcome::CRITICAL;
        }
        if ($score === 0) {
            return Outcome::FUMBLE;
        }

        $cumulatedProbabilities = 0;
        foreach ($this->resultLadder as $possibleResult) {
            if ($score > $possibleResult->probabiliy + $cumulatedProbabilities) {
                $cumulatedProbabilities += $possibleResult->probabiliy;
                continue;
            }

            return $possibleResult->outcome;
        }

        // ladder is not reaching 100 ? Critical
        return Outcome::CRITICAL;
    }

    public function getResults(): array
{
    return $this->resultLadder;
}
}
