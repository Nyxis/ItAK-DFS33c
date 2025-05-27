<?php

require_once 'Tirage.php';

class De extends Tirage {
    private int $faces;

    public function __construct(int $faces) {
        $this->faces = $faces;
    }

    public function tirer(): Resultat {
        $valeur = random_int(1, $this->faces);
        return new Resultat($valeur, 1, $this->faces);
    }
}
