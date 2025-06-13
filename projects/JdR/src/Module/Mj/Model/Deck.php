<?php

namespace Module\Mj\Model;

/**
 * A deck of cards, producing a result by flipping the first card in it
 */
class Deck extends GameAccessory
{
    private int $nbCards;
    private int $medianValue;
    private array $currentCard;

    public function __construct(
        private array $colors,
        private array $values
    ) {
        $this->nbCards = count($this->colors) * count($this->values);
        $this->medianValue = floor($this->nbCards / 2);

        $this->shuffle();
    }

    /**
     * Shuffle the deck
     */
    public function shuffle() : self
    {
        // /!\ both arrays are 0 indexed
        $this->currentCard = [
            array_rand($this->colors),   // color at random
            array_rand($this->values)    // value at random
        ];

        return $this;
    }

    /**
     * Flip the first card and return it's value
     * @return
     */
    public function revealFirstCard() : string
    {
        [$color, $value] = $this->currentCard;

        return sprintf("%s%s ",
            $this->values[$value],
            $this->colors[$color]
        );
    }

    /**
     * {@inherit_doc}
     */
    public function generateRandomPercentScore() : int
    {
        $this->shuffle();

        [$color, $value] = $this->currentCard;
        $flattenedValue = ($color + 1) * ($value + 1); // 0 indexed

        return round($flattenedValue * 100 / $this->nbCards);
    }

}
