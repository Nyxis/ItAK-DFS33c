<?php

require_once 'De.php';
require_once 'Piece.php';
require_once 'Deck.php';
require_once 'Resultat.php';
require_once 'ResultatStatut.php';
require_once 'Rencontre.php';

class GameMaster {
    private array $materiels = [];

    public function __construct() {
        $this->materiels[] = new De(6);
        $this->materiels[] = new De(20);
        $this->materiels[] = new Piece(2);
        $this->materiels[] = new Piece(3);
        $this->materiels[] = new Deck(3, 18);
        $this->materiels[] = new Deck(4, 13);
    }

    public function resoudreRencontre(Rencontre $rencontre): ResultatStatut {
        $index = array_rand($this->materiels);
        $objet = $this->materiels[$index];
        $resultat = $objet->tirer();

        echo "Rencontre : {$rencontre->nom} | {$resultat}" . PHP_EOL;

        return match (true) {
            $resultat->score === 100.0 => ResultatStatut::REUSSITE_CRITIQUE,
            $resultat->score < $rencontre->seuilFumble => ResultatStatut::FUMBLE,
            $resultat->value <= $resultat->median => ResultatStatut::ECHEC,
            default => ResultatStatut::REUSSITE,
        };
    }
}
