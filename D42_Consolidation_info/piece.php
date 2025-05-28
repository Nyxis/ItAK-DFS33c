<?php

require_once 'Tirage.php';

class Piece extends Tirage {
    private int $nombreLancers;

    public function __construct(int $nombreLancers) {
        $this->nombreLancers = $nombreLancers;
    }

    private function lancer(int $nb): int {
        if ($nb <= 0) return 0;
        return random_int(1, 2) + $this->lancer($nb - 1);
    }

    public function tirer(): Resultat {
        $valeur = $this->lancer($this->nombreLancers);
        $min = $this->nombreLancers * 1;
        $max = $this->nombreLancers * 2;
        return new Resultat($valeur, $min, $max);
    }
}
