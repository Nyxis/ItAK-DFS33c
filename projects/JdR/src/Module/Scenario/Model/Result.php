<?php

namespace Module\Scenario\Model;

use Lib\ValueObject\PositiveInt;

/**
 * An Encounter possible result
 */
class Result
{
    public function __construct(
        public readonly PositiveInt $probabiliy,
        public readonly Outcome $outcome
    ) {
    }

    public function __toString() : string
    {
        return sprintf('%s < %d',
            $this->outcome->toString(),
            $this->probabiliy->value
        );
    }
}
