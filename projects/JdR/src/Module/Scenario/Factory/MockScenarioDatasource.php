<?php

namespace Module\Scenario\Factory;

use Lib\Persistence\Datasource;
use Lib\ValueObject\PositiveInt;
use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;
use Module\Scenario\Model\Result;
use Module\Scenario\Model\Scenario;

class MockScenarioDatasource implements Datasource
{
    public function __construct()
    {
        $this->scenarios = [
            new Scenario(
                'Le Comte est Bon (mais l’équipe est nulle)',
                new Encounter(
                    'L’Oracle Bourré au Clerjus d’Ail',
                    'Dans deux jours, le destin te prendra... par surprise... ou par les pieds... J’sais plus.',
                    new Result(new PositiveInt(25), Outcome::FAILURE),
                    new Result(new PositiveInt(75), Outcome::SUCCESS),
                ),
                new Encounter(
                    'Le Poney Boiteux de la Forêt Moite',
                    'Il hennit en ancien elfique et botte à 1d12.',
                    new Result(new PositiveInt(5), Outcome::FUMBLE),
                    new Result(new PositiveInt(25), Outcome::FAILURE),
                    new Result(new PositiveInt(60), Outcome::SUCCESS),
                ),
                new Encounter(
                    'Le Village des Gobelins Véganophiles',
                    'Goûte au tofu sacré étranger, c’est à gerber, mais il te donera un bon fumé !',
                    new Result(new PositiveInt(10), Outcome::FUMBLE),
                    new Result(new PositiveInt(25), Outcome::FAILURE),
                    new Result(new PositiveInt(50), Outcome::SUCCESS),
                ),
                new Encounter(
                    'Le Syndicat des Nécromanciens Marxistes',
                    'Plus-value ou post-vie ? Il faut choisir, camarade.',
                    new Result(new PositiveInt(10), Outcome::FUMBLE),
                    new Result(new PositiveInt(25), Outcome::FAILURE),
                    new Result(new PositiveInt(50), Outcome::SUCCESS),
                ),
                new Encounter(
                    'Le Comte de Torture Administrative',
                    'Jean-Didier ne tue pas. Il ajourne à perpétuité. Lex Papyrum, Dolor Eternum.',
                    new Result(new PositiveInt(10), Outcome::FUMBLE),
                    new Result(new PositiveInt(25), Outcome::FAILURE),
                    new Result(new PositiveInt(50), Outcome::SUCCESS),
                )
            )
        ];
    }

    public function loadAll() : \Iterator
    {
        yield from $this->scenarios;
    }
}
