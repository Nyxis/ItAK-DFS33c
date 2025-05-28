<?php

require_once 'ResultatStatut.php';

class Resultat {
    public readonly int $value;
    public readonly int $min;
    public readonly int $max;
    public readonly int $median;
    public readonly float $score;

    public function __construct(int $value, int $min, int $max) {
        $this->value = $value;
        $this->min = $min;
        $this->max = $max;
        $this->median = intdiv($min + $max, 2);
        $this->score = ($max > $min) ? (($value - $min) / ($max - $min)) * 100 : 0;
    }

    public function __toString(): string {
        return "Valeur : {$this->value} (score : " . round($this->score, 2) . "%)";
    }
}
