<?php

require_once __DIR__ . '/Equipement.php';

interface Equiper {
    public function equiper(Equipement $equipement): void;
}

interface Soigner {
    public function soigner(int $quantite): void;
}

interface Blesser {
    public function blesser(int $quantite): void;
}

interface Evoluer {
    public function monterNiveau(): void;
}

class Personnage implements Equiper, Soigner, Blesser, Evoluer {
    public string $pseudo;
    public int $niveau;
    public int $pv;
    public int $pvMax = 100;
    /** @var Equipement[] */
    public array $equipements = [];
    public int $blessureCompteur = 0;

    public function __construct(string $pseudo, int $niveau = 1, int $pv = 100) {
        $this->pseudo = $pseudo;
        $this->niveau = $niveau;
        $this->pv = $pv;
        $this->pvMax = $pv;
    }

    public function equiper(Equipement $equipement): void {
        $this->equipements[] = $equipement;
        echo "{$this->pseudo} a équipé {$equipement->getNom()}.\n";
    }

    public function soigner(int $quantite): void {
        $this->pv += $quantite;
        if ($this->pv > $this->pvMax) {
            $this->pv = $this->pvMax;
        }
    }

    public function blesser(int $quantite): void {
        $this->pv -= $quantite;
        $this->blessureCompteur += 1;
        if ($this->pv < 0) {
            $this->pv = 0;
        }
    }

    public function monterNiveau(): void {
        $this->niveau += 1;
        $this->pvMax += 1;
        $this->soigner(1);
    }

    public function getPuissance(): int {
        $bonusEquipement = count($this->equipements);
        $malusBlessure = intdiv($this->blessureCompteur, 2); // -1 tous les 2 blessures
        return $this->niveau + $bonusEquipement - $malusBlessure;
    }
}
