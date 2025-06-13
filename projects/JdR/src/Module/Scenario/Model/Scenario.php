<?php

namespace Module\Scenario\Model;

/**
 * An RPG Scenario, like a book
 */
class Scenario
{
    /**
     * @var Encounter[]
     */
    private array $encounters;

    public function __construct(
        public readonly string $name,
        Encounter ...$encounters
    ) {
        $this->encounters = $encounters;
    }

    /**
     * Generate all Encounters
     */
    public function play(): \Iterator
    {
        yield from $this->encounters;
    }
}
