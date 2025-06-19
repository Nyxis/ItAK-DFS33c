<?php

namespace Module\Character\Factory;

use Module\Character\Model\Character;
use Lib\ValueObject\PositiveInt;

class CharacterFactory
{
    public function create(array $data): Character
    {
        return new Character(
            name: $data['name'],
            baseHealth: new PositiveInt($data['health']),
            level: new PositiveInt($data['level'] ?? 1)
        );
    }
}
