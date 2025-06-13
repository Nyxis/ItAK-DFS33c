<?php

namespace Module\Mj\Model;

/**
 * A dice, producing a result between 0 and the max value given as argument.
 */
class Dice extends GameAccessory
{
    private int $medianValue;

    public function __construct(
        private int $nbFaces
    ) {
        $this->medianValue = floor($nbFaces / 2);
    }

    /**
     * Rolls this game die and return his result as an int.
     * @return int
     */
    public function roll() : int
    {
        return rand(1, $this->nbFaces);
    }

    /**
     * {@inherit_doc}
     */
    public function generateRandomPercentScore() : int
    {
        $value = $this->roll();

        return round($value * 100 / $this->nbFaces);
    }
}
