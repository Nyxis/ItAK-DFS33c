<?php

namespace Module\Scenario;

class ScenarioEncounter
{
    /**
     * @param string $description
     * @param array $choices
     */
    public function __construct(
        private string $description,
        private array $choices
    ) {}

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getChoices(): array
    {
        return $this->choices;
    }
} 