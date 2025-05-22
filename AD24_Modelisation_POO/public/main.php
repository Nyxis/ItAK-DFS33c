<?php


echo 'TEST  DOCKER affichage page';


class GameMaster{
 //choix aléatoire d'un matériel pour tirage
}

class Resultat_tirage {
    public string $type;
    public string $resultat;
     //variable valeur??
    public function __construct(string $type, string $resultat ) //Valeur?
    { 
        }
};

interface Tirage_aleatoire {
    public function tirer(): Resultat_tirage;
}

//Matériels utilisés, interface comportement tirage
// Chaque matériel renvoi Resultat_tirage
// class Dé implements Comportement_tirage {
//     public function tirer() : Resultat_tirage {
//         $chiffre = rand(1;6);
//         $resultat_lancé = $chiffre;
//     }
// }


class Dé{
    public int $value;
    public function __construct(
        public readonly int $nbFaces 
        ){
            $this->nbFaces = $nbFaces;
            $this->roll();
        }
    public function roll() {
        $this->value = rand(1, $this->nbFaces);
        return $this->value;
    }

    public function setValue(int $value) {
        $this->value = $value;
    }
}
$dé = new Dé(2);

class Pièce {
    public int $value;
    public function __construct(
    $nbLancers = 1 ) {
        $this->flip();
    }
    
    public function flip() {
        $this->value = rand(0, 1);
    }

    public function setValue(int $value) {
        if ($this->value === 0) {
            $this->value = "Face";
        } else if ($this->value === 1) {
            $value = "Pile";
        } else {
            echo "Pièce perdue, recommencez";
        }
        return $value;
    }
}

// class Deck {


    
//     public function __construct(
//         public readonly int $nbCouleurs, public readonly int $nbValeurs 
//         ){
//             $this->nbCouleurs= $nbCouleurs;
//             $this->nbValeurs = $nbValeurs;
//             $this->draw();
//         }
//     public function draw () {
//         $this->nbCouleurs = rand(1, $this->nbCouleurs);
//         $this->nbValeurs = rand(1, $this-> nbValeurs);
//         $this->value = $this->nbCouleurs . "de"  $this->nbValeurs;
//     }

//     public function setValue(int $value) {
//         $this->value = $value;
//     }
// }

// enum Resultat : string
// {
//     case FUMBLE = 'fumble';
//     case ECHEC = 'échec';
//     case REUSSITE = 'réussite';
//     case REUSSITE_CRITIQUE = 'réussite critique';
// }


?>