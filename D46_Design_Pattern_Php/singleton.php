<?php


// new Singleton;

// $objet->.....
// Class::



$singleton = Singleton::create();


class Singleton
{
    private static self $instance;

    public static function create() : self
    {
        return self::$instance ?
            self::$instance :
            (self::$instance = new Singleton())
        ;
    }

    private function __construct()
    {

    }
}
