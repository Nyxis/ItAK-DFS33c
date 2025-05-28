<?php

class Biere extends Boisson
{
function amenerBiere(string $serveur, string $typeBiere) : Biere
{
    switch ($serveur) {
        case 'Nyx':
            echo 'Bonjour, avec plaisir';
            break;
        case 'JD':
            echo 'Prend du vin jeune con.';
            break;
        default:
            die("Le serveur $serveur n'existe pas");
    }

    return new Biere($typeBiere);
}
} 
abstract class Serveur
{
    abstract public function amenerBiere(string $typeBiere) : Biere;

    protected function tirerBiere(string $typeBiere) : Biere
    {
        return new Biere($typeBiere);
    }
}
class Nyx extends Serveur
{
    public function amenerBiere(string $typeBiere) : Biere
    {
        echo 'Bonjour, avec plaisir';

        return $this->tirerBiere($typeBiere);
    }
}
class JD extends Serveur
{
    public function amenerBiere(string $typeBiere) : Biere
    {
        echo 'Prend du vin jeune con.';

        return $this->tirerBiere($typeBiere);
    }
}

$serveur = new Nyx();
$serveur = new JD();
$client->demanderBiere(/*Serveur*/ $serveur);

class Constat
{
    public function __construct(
        public Vehicule $vehicule1,
        public Vehicule $vehicule2,
    )
    {
    }
}

interface Soda
{
    public function isSucree() : bool;
    public function isGazeux() : bool;
}
class Boisson
{
    protected string $type;

    public function __construct(string $type = 'inconnue')
    {
        $this->type = $type;
    }
}

interface Taxable
{
    public function getTaxRate() : float;
}

abstract class BoissonSucree extends Boisson
{
    public function isSucree() : bool
    {
        return true;
    }
}

class IceTea extends BoissonSucree implements Soda, Taxable
{
    public function getTaxRate() : float
    {
        return 0;
    }

    public function isGazeux() : bool
    {
        return false;
    }

    public function isFruite() : bool
    {
        return true;
    }
}

class CocaCola extends BoissonSucree implements Soda
{
    public function isSucree() : bool
    {
        return true;
    }

    public function isGazeux() : bool
    {
        return true;
    }

    public function isFruite() : bool
    {
        return false;
    }

}






interface Vehicule
{
    public function drive();
    public function isImmobile() : bool;
}

interface VehiculeAutonome extends Vehicule
{
    public function sigStop();
}

abstract class MobilierUrbain
{
    protected int $taille;
}
class Voiture implements Vehicule, Taxable
{
    public function drive()
    {
    }

    public function isImmobile() : bool
    {
        return false;
    }

    public function getTaxRate() : float
    {
        // Return a default tax rate, adjust as needed
        return 0.2;
    }
}

class Scooter implements Vehicule
{
    public function drive()
    {
    }

    public function isImmobile() : bool
    {
        return false;
    }
}
