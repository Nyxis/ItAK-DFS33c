<?php

namespace Module\Scenario\Strategy;

use Module\Scenario\Model\Encounter;
use Module\Scenario\Model\Outcome;

class DefaultResolutionStrategy implements ResolutionStrategy
{
    public function resolve(Encounter $encounter, int $score): Outcome
    {
        return $encounter->internalResolve($score);
    }
}
