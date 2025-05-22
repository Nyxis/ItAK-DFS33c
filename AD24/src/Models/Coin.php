<?php

namespace App\Models;

class Coin implements RandomDrawable
{
    public function __construct(
        private readonly int $flips
    ) {
        if ($flips < 1) {
            throw new \InvalidArgumentException("Le nombre de lancers doit être au moins 1");
        }
    }

    private function flipRecursive(int $remainingFlips): int
    {
        if ($remainingFlips === 0) {
            return 0;
        }

        return (random_int(0, 1) + $this->flipRecursive($remainingFlips - 1));
    }

    public function draw(): Result
    {
        $value = $this->flipRecursive($this->flips);
        $max = $this->flips;
        $median = ceil($max / 2);

        return new Result(
            value: $value,
            min: 0,
            max: $max,
            median: $median
        );
    }
} 