<?php

namespace App\Models;

class Dice implements RandomDrawable
{
    public function __construct(
        private readonly int $faces
    ) {
        if ($faces < 2) {
            throw new \InvalidArgumentException("Un dé doit avoir au moins 2 faces");
        }
    }

    public function draw(): Result
    {
        $value = random_int(1, $this->faces);
        $median = ceil($this->faces / 2);
        
        return new Result(
            value: $value,
            min: 1,
            max: $this->faces,
            median: $median
        );
    }
} 