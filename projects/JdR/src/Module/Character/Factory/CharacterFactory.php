<?php

namespace Module\Character\Factory;

use Module\Character\Model\Character;
use Lib\ValueObject\PositiveInt;

class CharacterFactory
{
    public static function create(array $data): Character
    {
        return new Character(
            $data['name'],
            new PositiveInt($data['health']),
            new PositiveInt($data['level'] ?? 1)
        );
    }
}
