<?php

namespace Module\Character\Model;

use Lib\ValueObject\PositiveInt;

/**
 * An adventurers party, searching for conquest and glory
 * composite of Character
 */
class Party extends Character
{
    /**
     * @var Character[]
     */
    public array $adventurers;

    public function __construct(
        Character ...$adventurers
    ) {
        $this->adventurers = $adventurers;
    }

    /**
     * tests if this Party is alive
     * @return bool
     */
    public function isAlive() : bool
    {
        return array_any(
            $this->adventurers,
            fn(Character $adventurer) => $adventurer->isAlive()
        );
    }

    private function pickAlives(int $nb, callable $sorter) : array
    {
        $aliveAdventurers = array_filter(
            $this->adventurers,
            fn(Character $adventurer) => $adventurer->isAlive()
        );

        usort($aliveAdventurers, $sorter);

        return array_slice($aliveAdventurers, 0, $nb);
    }

    private function balance(int $quantity, callable $onEach, string $attribute, int $sortDirection = 1)
    {
        $picked = $this->pickAlives(
            $quantity,  // first x
            fn(Character $a, Character $b) => $sortDirection == 1 ?
                $a->$attribute <=> $b->$attribute :
                $b->$attribute <=> $a->$attribute
        );

        $i = 0;
        $pickedLength = count($picked);
        $decrem = fn(int $index) => $index == 0 ? $pickedLength-1 : $index-1;
        $increm = fn(int $index) => $index+1 >= $pickedLength ? 0 : $index+1;

        while($quantity > 0) {
            $current = $picked[$i];
            $onEach($current);
            $quantity--;

            $left = isset($picked[$i-1]) ? $picked[$i-1] : $picked[$pickedLength-1];
            $right = isset($picked[$i+1]) ? $picked[$i+1] : $picked[0];

            switch (true) {

                // current bigger than both
                case $left->$attribute < $current->$attribute
                    && $current->$attribute >= $right->$attribute:

                    $deltaLeft = $current->$attribute - $left->$attribute;
                    $deltaRight = $current->$attribute - $right->$attribute;

                    $i = $deltaLeft > $deltaRight ? $decrem($i) : $increm($i);
                    break;

                case $right->$attribute <= $current->$attribute:
                    $i = $increm($i);
                    break;

                case $left->$attribute < $current->$attribute:
                    $i = $decrem($i);
                    break;
            }
        }
    }

    public function heal(PositiveInt $healingPower = new PositiveInt(1)) : void
    {
        $this->balance(
            $healingPower->value,  // split all heal
            fn(Character $adventurer) => $adventurer->heal(),
            'currentHealth'
        );
    }

    public function hurt(PositiveInt $nbWounds = new PositiveInt(1)) : void
    {
        $this->balance(
            1,  // only one gets the hit
            fn(Character $adventurer) => $adventurer->hurt($nbWounds),
            'currentHealth',
            -1, // but on the highest remaining hp
        );
    }

    public function levelUp(PositiveInt $nbLevels = new PositiveInt(1)) : void
    {
        $this->balance(
            $nbLevels->value,
            fn(Character $adventurer) => $adventurer->levelUp(),
            'level'
        );
    }

    /**
     * Dewey style
     */
    public function kill() : void
    {
        $this->adventurers[array_rand($this->adventurers)]->kill();
    }

    public function __toString() : string
    {
        usort(
            $this->adventurers,
            fn(Character $a, Character $b) => $a->name <=> $b->name
        );

        return implode(
            "  |  ",
            array_map(
                fn(Character $adventurer) => (string) $adventurer,
                $this->adventurers
            )
        );
    }

    public function __clone()
    {
        $this->adventurers = array_map(
            fn(Character $adventurer) => clone $adventurer,
            $this->adventurers
        );
    }
}
