<?php

declare(strict_types=1);

namespace AD24\Models;

interface ModificateurPuissance
{
    public function appliquer(int $puissance): int;
}

interface Affichable
{
    public function afficher(): string;
}

trait ValidationTrait
{
    protected function validerPositif(int $valeur, string $nom): void
    {
        if ($valeur < 0) {
            throw new \InvalidArgumentException("$nom ne peut pas être négatif");
        }
    }
}

class StatistiquesBase
{
    use ValidationTrait;
    
    public function __construct(
        protected int $valeur,
        protected readonly int $maximum
    ) {
        $this->validerPositif($this->valeur, 'Valeur');
        $this->validerPositif($this->maximum, 'Maximum');
        if ($this->valeur > $this->maximum) {
            $this->valeur = $this->maximum;
        }
    }

    public function getValeur(): int { return $this->valeur; }
    public function getMaximum(): int { return $this->maximum; }
    public function estComplet(): bool { return $this->valeur >= $this->maximum; }
    
    public function modifier(int $changement): void
    {
        $this->valeur = max(0, min($this->maximum, $this->valeur + $changement));
    }
}

class PointsDeVie extends StatistiquesBase implements ModificateurPuissance
{
    public function estVivant(): bool { return $this->valeur > 0; }
    public function estBlesse(): bool { return !$this->estComplet(); }
    
    public function appliquer(int $puissance): int
    {
        return $this->estBlesse() ? (int)($puissance * 0.8) : $puissance;
    }
}

class Equipement implements ModificateurPuissance, Affichable
{
    use ValidationTrait;
    
    public function __construct(
        private int $puissance = 0,
        private int $defense = 0
    ) {
        $this->validerPositif($this->puissance, 'Puissance');
        $this->validerPositif($this->defense, 'Défense');
    }

    public function getPuissance(): int { return $this->puissance; }
    public function getDefense(): int { return $this->defense; }
    
    public function appliquer(int $puissance): int
    {
        return $puissance + $this->puissance;
    }
    
    public function ameliorer(int $puissance, int $defense): void
    {
        $this->puissance += max(0, $puissance);
        $this->defense += max(0, $defense);
    }
    
    public function afficher(): string
    {
        return "Équipement: +{$this->puissance} ATK, +{$this->defense} DEF";
    }
}

class Experience extends StatistiquesBase
{
    private const XP_BASE = 100;
    
    public function __construct(int $niveau = 1)
    {
        parent::__construct(0, $this->calculerXpRequise($niveau));
        $this->niveau = $niveau;
    }
    
    private int $niveau;
    
    public function getNiveau(): int { return $this->niveau; }
    
    public function gagner(int $xp): bool
    {
        if ($xp <= 0) return false;
        
        $this->valeur += $xp;
        return $this->monterSiPossible();
    }
    
    private function monterSiPossible(): bool
    {
        if ($this->valeur >= $this->maximum) {
            $this->niveau++;
            $this->valeur -= $this->maximum;
            $this->maximum = $this->calculerXpRequise($this->niveau);
            return true;
        }
        return false;
    }
    
    private function calculerXpRequise(int $niveau): int
    {
        return self::XP_BASE * $niveau;
    }
}

class CalculateurPuissance
{
    public function calculer(int $niveau, ModificateurPuissance ...$modificateurs): int
    {
        $puissance = $niveau * 10;
        
        foreach ($modificateurs as $modificateur) {
            $puissance = $modificateur->appliquer($puissance);
        }
        
        return $puissance;
    }
}

class Personnage implements Affichable
{
    use ValidationTrait;
    
    private PointsDeVie $pv;
    private Equipement $equipement;
    private Experience $experience;
    private CalculateurPuissance $calculateur;

    public function __construct(
        private readonly string $pseudo,
        int $pvMax = 100,
        int $niveau = 1
    ) {
        if (empty(trim($this->pseudo))) {
            throw new \InvalidArgumentException('Pseudo requis');
        }
        
        $this->pv = new PointsDeVie($pvMax, $pvMax);
        $this->equipement = new Equipement();
        $this->experience = new Experience($niveau);
        $this->calculateur = new CalculateurPuissance();
    }

    // Getters compacts
    public function getPseudo(): string { return $this->pseudo; }
    public function getNiveau(): int { return $this->experience->getNiveau(); }
    public function getPv(): int { return $this->pv->getValeur(); }
    public function getPvMax(): int { return $this->pv->getMaximum(); }
    public function getXp(): int { return $this->experience->getValeur(); }
    public function estVivant(): bool { return $this->pv->estVivant(); }
    public function estBlesse(): bool { return $this->pv->estBlesse(); }

    // Actions fluides
    public function subir(int $degats): self
    {
        $this->pv->modifier(-$degats);
        return $this;
    }
    
    public function soigner(int $montant): self
    {
        $this->pv->modifier($montant);
        return $this;
    }
    
    public function equiper(int $puissance, int $defense = 0): self
    {
        $this->equipement = new Equipement($puissance, $defense);
        return $this;
    }
    
    public function gagnerXp(int $xp): bool
    {
        $monte = $this->experience->gagner($xp);
        if ($monte) {
            $this->ameliorerStats();
        }
        return $monte;
    }
    
    public function getPuissance(): int
    {
        return $this->calculateur->calculer(
            $this->getNiveau(),
            $this->equipement,
            $this->pv
        );
    }
    
    public function afficher(): string
    {
        return sprintf(
            "=== %s ===\nNiv.%d | PV:%d/%d | XP:%d/%d\nPuissance: %d | %s\n%s",
            $this->pseudo,
            $this->getNiveau(),
            $this->getPv(),
            $this->getPvMax(),
            $this->getXp(),
            $this->experience->getMaximum(),
            $this->getPuissance(),
            $this->estBlesse() ? '🩸 Blessé' : '💪 En forme',
            $this->equipement->afficher()
        );
    }
    
    private function ameliorerStats(): void
    {
        $nouveauMax = $this->pv->getMaximum() + 20;
        $this->pv = new PointsDeVie($this->pv->getValeur() + 20, $nouveauMax);
    }
}
