<?php

require_once 'Resultat.php';

abstract class Tirage {
    abstract public function tirer(): Resultat;
}
