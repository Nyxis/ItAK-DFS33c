<?php

namespace Module\Scenario\Model;

use Lib\ValueObject\PositiveInt;

/**
 * A representation of an Encounter in an RPG
 */
class Encounter
{
    const int MAX_TRIES = 2;
    const int EXPE_BUFF = 15;

    /**
     * @var Result[]
     */
    private array $resultLadder;

    public function __construct(
        public readonly string $title,
        public readonly string $flavour,
        Result ...$results
    ) {
        $max = array_reduce(
            $results,
            function (int $ladder, Result $result) {

                $this->resultLadder[] = new Result(
                    new PositiveInt($ladder = min($ladder + $result->probability->value, 100)),
                    $result->outcome
                );

                return $ladder;
            },
            0
        );

        if ($max < 100) {   // adds 100 if not set
            $this->resultLadder[] = new Result(
                new PositiveInt(100),
                Outcome::CRITICAL
            );
        }
    }

    public function internalResolve(int $score) : Outcome
    {
        if ($score >= 100) {
            return Outcome::CRITICAL;
        }
        if ($score === 0) {
            return Outcome::FUMBLE;
        }

        // Php 8.4
        // @see https://www.php.net/manual/fr/function.array-find.php
        return array_find(
                $this->resultLadder,
                fn(Result $possibleResult) => $score < $possibleResult->probability->value
            )
            ->outcome
        ;
    }

    public function __toString() : string
    {
        return sprintf("📜 %s\n%s\n(%s)",
            $this->title,
            $this->flavour,
            implode(' < ', array_map(
                fn(Result $result) => (string) $result,
                $this->resultLadder
            ))
        );
    }
}

