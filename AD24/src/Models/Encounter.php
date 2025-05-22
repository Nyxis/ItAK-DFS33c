<?php

namespace App\Models;

class Encounter
{
    private float $successModifier = 0;

    public function __construct(
        private readonly string $name,
        private readonly float $difficulty = 1.0
    ) {}

    public function improveSuccessRate(float $amount): void
    {
        $this->successModifier += $amount;
    }

    public function resolveOutcome(Result $result): Outcome
    {
        $score = $result->getScore() + ($this->successModifier * 100);
        
        // Limiter le score entre 0 et 100
        $score = max(0, min(100, $score));
        
        // Ajuster les seuils en fonction de la difficulté
        $criticalThreshold = 95 / $this->difficulty;
        $successThreshold = 50 / $this->difficulty;
        $fumbleThreshold = 5 * $this->difficulty;

        return match(true) {
            $score >= $criticalThreshold => Outcome::CRITICAL,
            $score >= $successThreshold => Outcome::SUCCESS,
            $score <= $fumbleThreshold => Outcome::FUMBLE,
            default => Outcome::FAILURE
        };
    }
} 