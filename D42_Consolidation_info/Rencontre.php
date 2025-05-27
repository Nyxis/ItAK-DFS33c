<?php

class Rencontre {
    public string $nom;
    public float $seuilFumble;

    public function __construct(string $nom, float $seuilFumble = 20.0) {
        $this->nom = $nom;
        $this->seuilFumble = $seuilFumble;
    }
}
