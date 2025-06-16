<?php

namespace Module\Scenario;

class Scenario
{
    /**
     * @param string $title
     * @param ScenarioEncounter[] $encounters
     * @param Result $result
     */
    public function __construct(
        private string $title,
        private array $encounters,
        private Result $result
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return ScenarioEncounter[]
     */
    public function getEncounters(): array
    {
        return $this->encounters;
    }

    public function getResult(): Result
    {
        return $this->result;
    }
} 