<?php

require_once 'ResultatStatut.php';

class Resultat {
    public readonly int $valeur;
    public readonly ResultatStatut $statut;

    public function __construct(int $valeur, ResultatStatut $statut) {
        $this->valeur = $valeur;
        $this->statut = $statut;
    }

    public function getValeur(): int {
        return $this->valeur;
    }

    public function getStatut(): ResultatStatut {
        return $this->statut;
    }

    public function __toString(): string {
        return "Résultat : {$this->valeur} ({$this->statut->value})";
    }
}
