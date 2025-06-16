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

    public function getEncounters(): array
    {
        return $this->encounters;
    }
    public function play(): \Iterator
    {
        yield from $this->encounters;
    }
}
