<?php

namespace App\Models;

class Deck implements RandomDrawable
{
    public function __construct(
        private readonly int $colors,
        private readonly int $values
    ) {
        if ($colors < 1 || $values < 1) {
            throw new \InvalidArgumentException("Le nombre de couleurs et de valeurs doit être au moins 1");
        }
    }

    public function draw(): Result
    {
        $colorValue = random_int(1, $this->colors);
        $cardValue = random_int(1, $this->values);
        
        $value = ($colorValue - 1) * $this->values + $cardValue;
        $max = $this->colors * $this->values;
        $median = ceil($max / 2);

        return new Result(
            value: $value,
            min: 1,
            max: $max,
            median: $median
        );
    }
} 