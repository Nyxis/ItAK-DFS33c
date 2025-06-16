<?php

namespace Module\Scenario\Strategy;

use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;

interface ResolutionStrategy
{
    public function resolve(Encounter $encounter, int $score): Outcome;
}
