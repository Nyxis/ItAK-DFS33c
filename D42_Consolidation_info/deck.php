<?php

require_once 'Tirage.php';

class Deck extends Tirage {
    private int $nbCouleurs;
    private int $nbValeurs;

    public function __construct(int $nbCouleurs, int $nbValeurs) {
        $this->nbCouleurs = $nbCouleurs;
        $this->nbValeurs = $nbValeurs;
    }

    public function tirer(): Resultat {
        $couleur = random_int(1, $this->nbCouleurs);
        $valeur = random_int(1, $this->nbValeurs);

        $valeurFinale = ($couleur - 1) * $this->nbValeurs + $valeur;

        $min = 1;
        $max = $this->nbCouleurs * $this->nbValeurs;
        $statut = $this->calculerStatut($valeurFinale, $min, $max);

        return new Resultat($valeurFinale, $statut);
    }
}
