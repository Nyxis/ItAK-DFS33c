<?php

enum TypeResultat: string {
    case ECHEC = 'échec';
    case REUSSITE = 'réussite';
    case CRITIQUE = 'réussite critique';
    case FUMBLE = 'fumble';
}

class ResultatTirage {
    public int $score;

    public function __construct(
        public readonly int $value,
        public readonly int $min,
        public readonly int $max,
        public readonly int $median,
        public readonly string $details = ''
    ) {
        $this->score = (int)(($this->value - $this->min) / ($this->max - $this->min) * 100);
    }

    public function __toString(): string {
        return "Tirage : {$this->value} ({$this->score}%) - {$this->details}";
    }
}

class ComportementDeTirage {
    public static function analyser(ResultatTirage $result): TypeResultat {
        if ($result->value == $result->min) return TypeResultat::FUMBLE;
        if ($result->value == $result->max) return TypeResultat::CRITIQUE;
        if ($result->value < $result->median) return TypeResultat::ECHEC;
        return TypeResultat::REUSSITE;
    }
}

interface Tirable {
    public function tirer(): ResultatTirage;
}

class De implements Tirable {
    private int $faces;

    public function __construct(int $faces) {
        $this->faces = $faces;
    }

    public function tirer(): ResultatTirage {
        $valeur = rand(1, $this->faces);
        return new ResultatTirage($valeur, 1, $this->faces, (int)ceil($this->faces / 2), "Dé ($valeur)");
    }
}

class Piece implements Tirable {
    private int $nombreLancers;

    public function __construct(int $nombreLancers) {
        $this->nombreLancers = $nombreLancers;
    }

    public function tirer(): ResultatTirage {
        $valeur = $this->lancer();
        return new ResultatTirage($valeur, 0, $this->nombreLancers, (int)ceil($this->nombreLancers / 2), "Pièce ($valeur sur $this->nombreLancers)");
    }

    private function lancer(): int {
        $resultat = 0;
        for ($i = 0; $i < $this->nombreLancers; $i++) {
            $resultat += rand(0, 1);
        }
        return $resultat;
    }
}

class Piece2 implements Tirable {
    public function tirer(): ResultatTirage {
        $ratés = $this->lancerRecursive(0);
        return new ResultatTirage($ratés, 0, 10, 5, "$ratés tentatives échouées avant PILE");
    }

    private function lancerRecursive(int $ratés): int {
        $tirage = rand(0, 1);
        return $tirage === 1 ? $ratés : $this->lancerRecursive($ratés + 1);
    }
}

class Carte {
    public int $valeur;
    public string $couleur;

    public function __construct(int $valeur, string $couleur) {
        $this->valeur = $valeur;
        $this->couleur = $couleur;
    }

    public function __toString(): string {
        return "{$this->valeur} de {$this->couleur}";
    }
}

class JeuDeCartes implements Tirable {
    private array $cartes = [];
    private int $valeursMax;
    private array $couleurs;

    public function __construct(int $valeursMax = 13, array $couleurs = ['cœur', 'pique', 'carreau', 'trèfle']) {
        $this->valeursMax = $valeursMax;
        $this->couleurs = $couleurs;

        foreach ($this->couleurs as $couleur) {
            for ($i = 1; $i <= $valeursMax; $i++) {
                $this->cartes[] = new Carte($i, $couleur);
            }
        }
    }

    public function tirer(): ResultatTirage {
        shuffle($this->cartes);
        $carte = array_pop($this->cartes);
        return new ResultatTirage($carte->valeur, 1, $this->valeursMax, (int)ceil($this->valeursMax / 2), "Carte tirée : $carte");
    }
}

class Rencontre {
    public int $bonus;
    public string $nom;

    public function __construct(string $nom, int $bonus = 0) {
        $this->nom = $nom;
        $this->bonus = $bonus;
    }
}

class GameMaster {
    private array $instruments = [];

    public function __construct() {
        $this->instruments[] = new De(6);
        $this->instruments[] = new De(20);
        $this->instruments[] = new De(10);

        $this->instruments[] = new Piece(3);
        $this->instruments[] = new Piece2();

        $this->instruments[] = new JeuDeCartes(13);
        $this->instruments[] = new JeuDeCartes(18, ['cœur', 'pique', 'trèfle']);
    }

    public function tirerAvecBonus(int $bonus = 0): TypeResultat {
        $instrument = $this->instruments[array_rand($this->instruments)];
        $resultat = $instrument->tirer();
        $resultat->score += $bonus;

        if ($resultat->score >= 100) return TypeResultat::CRITIQUE;
        if ($resultat->score >= 60) return TypeResultat::REUSSITE;
        if ($resultat->score >= 30) return TypeResultat::ECHEC;
        return TypeResultat::FUMBLE;
    }

    public function resoudreScenario(array $rencontres): void {
        $echecs = 0;
        $echecsSuccessifs = 0;

        foreach ($rencontres as $index => $rencontre) {
            echo "<h3>Rencontre " . ($index + 1) . " : {$rencontre->nom}</h3>";
            $resultat = $this->tirerAvecBonus($rencontre->bonus);
            echo "Résultat : {$resultat->value}<br>";

            if ($resultat === TypeResultat::FUMBLE) {
                echo "<strong>Le groupe meurt suite à un fumble !</strong>";
                return;
            }
            if ($resultat === TypeResultat::ECHEC) {
                $echecs++;
                $echecsSuccessifs++;

                if ($echecsSuccessifs >= 2 || $echecs >= 4) {
                    echo "<strong>Le groupe meurt après trop d'échecs.</strong>";
                    return;
                }

                echo "Échec ! On relance avec un bonus de +15%...<br>";
                $rencontre->bonus += 15;
                continue;
            }
            if ($resultat === TypeResultat::CRITIQUE) {
                $echecs = max(0, $echecs - 1);
                $echecsSuccessifs = 0;
                echo "<strong>Succès critique ! Le groupe trouve une potion !</strong><br>";
            } else {
                $echecsSuccessifs = 0;
                echo "Succès !<br>";
            }
        }
        echo "<h2>Scénario terminé avec succès !</h2>";
    }
}

// --- Lancement du programme ---

$gm = new GameMaster();
$scenario = [
    new Rencontre("Gobelin"),
    new Rencontre("Bandits"),
    new Rencontre("Ogre"),
    new Rencontre("Sorcier noir"),
    new Rencontre("Dragon")
];
$gm->resoudreScenario($scenario);