<?php

require_once 'De.php';
require_once 'Piece.php';
require_once 'Deck.php';
require_once 'Resultat.php';

class GameMaster {
    private array $materiels = [];

    public function __construct() {
        // Dés : par exemple d6, d20
        $this->materiels[] = new De(6);
        $this->materiels[] = new De(20);

        // Pièces : avec 2 et 3 lancers
        $this->materiels[] = new Piece(2);
        $this->materiels[] = new Piece(3);

        // Decks : (3 couleurs × 18 valeurs) et (4 couleurs × 13 valeurs)
        $this->materiels[] = new Deck(3, 18);
        $this->materiels[] = new Deck(4, 13);
    }

    public function pleaseGiveMeACrit(): string {
        $index = array_rand($this->materiels);
        $objet = $this->materiels[$index];
        $resultat = $objet->tirer();
        echo $resultat . PHP_EOL;
        return $resultat->getStatut()->value;
    }
}
