<?php

namespace App\Models;

class Result
{
    private int $score;

    public function __construct(
        public readonly int $value,
        public readonly int $min = 0,
        public readonly int $max,
        public readonly int $median
    ) {
        // Calcul du score en pourcentage
        $this->score = (($value - $min) / ($max - $min)) * 100;
    }

    public function getScore(): int
    {
        return $this->score;
    }
} 