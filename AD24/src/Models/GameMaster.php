<?php

namespace App\Models;

class GameMaster
{
    /** @var RandomDrawable[] */
    private array $items = [];

    public function __construct()
    {
        // Ajout des dés
        $this->items[] = new Dice(4);  // d4
        $this->items[] = new Dice(6);  // d6
        $this->items[] = new Dice(8);  // d8
        $this->items[] = new Dice(10); // d10
        $this->items[] = new Dice(12); // d12
        $this->items[] = new Dice(20); // d20
        $this->items[] = new Dice(100); // d100

        // Ajout des decks
        $this->items[] = new Deck(3, 18); // Premier deck
        $this->items[] = new Deck(4, 13); // Second deck

        // Ajout des pièces
        $this->items[] = new Coin(2); // Première pièce
        $this->items[] = new Coin(3); // Seconde pièce
    }

    public function pleaseGiveMeACrit(): Outcome
    {
        $randomItem = $this->items[array_rand($this->items)];
        $result = $randomItem->draw();
        
        return match(true) {
            $result->getScore() === 100 => Outcome::CRITICAL,
            $result->getScore() === 0 => Outcome::FUMBLE,
            $result->getScore() > 50 => Outcome::SUCCESS,
            default => Outcome::FAILURE
        };
    }
} 