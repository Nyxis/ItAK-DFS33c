<?php

namespace Module\Mj\Model;

/**
 * A coin, producing a result by flipping it n times
 */
class Coin extends GameAccessory
{
    private int $medianValue;

    public function __construct(
        private int $nbFlips
    ) {
        $this->medianValue = floor($nbFlips / 2);
    }

    /**
     * Recursive function for inner use
     */
    protected function flipUntilFailureOrMax(int $currentFlip) : int
    {
        if ($currentFlip >= $this->nbFlips) {
            return $currentFlip;
        }

        return rand(0, 1) === 1 ?
            $this->flipUntilFailureOrMax($currentFlip + 1) :
            $currentFlip
        ;
    }

    /**
     * Flip the coin until the max flips is reached or the toss is failed
     * and returns the numbre a successfull rolls
     *
     * @return int
     */
    public function flip() : int
    {
        return $this->flipUntilFailureOrMax(1 /* first flip */);
    }

    /**
     * {@inherit_doc}
     */
    public function generateRandomPercentScore() : int
    {
        $value = $this->flip();

        // bad calculation, score has to be calculated with
        // probability laws, each flip are not independants

        return round($value * 100 / $this->nbFlips);
    }
}
