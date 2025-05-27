<?php

require_once 'src/Personnage.php';
require_once 'src/Equipement.php';

$perso = new Personnage("Hero");

$perso->equiper(new Equipement("Épée"));
$perso->equiper(new Equipement("Bouclier"));

$perso->blesser(10);
$perso->blesser(5);
$perso->monterNiveau();

echo "Puissance : " . $perso->getPuissance() . "\n";
$perso->soigner(5);
echo "Points de vie après soin : " . $perso->pv . "\n";
