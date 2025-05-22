<?php

namespace App\Models;

class Scenario
{
    /** @var Encounter[] */
    private array $encounters = [];
    private int $totalFailures = 0;
    private int $consecutiveFailures = 0;
    private int $healingPotions = 0;

    public function __construct(private readonly GameMaster $gameMaster)
    {}

    public function addEncounter(Encounter $encounter): void
    {
        $this->encounters[] = $encounter;
    }

    private function handleOutcome(Outcome $outcome, Encounter $encounter): bool
    {
        switch ($outcome) {
            case Outcome::FUMBLE:
                return false; // Game Over
            
            case Outcome::FAILURE:
                $this->consecutiveFailures++;
                $this->totalFailures++;
                
                if ($this->consecutiveFailures >= 2 || $this->totalFailures >= 4) {
                    return false; // Game Over
                }
                
                $encounter->improveSuccessRate(0.15); // +15% pour le prochain essai
                return true;
            
            case Outcome::SUCCESS:
                $this->consecutiveFailures = 0;
                return true;
            
            case Outcome::CRITICAL:
                $this->consecutiveFailures = 0;
                $this->healingPotions++;
                if ($this->totalFailures > 0) {
                    $this->totalFailures--;
                }
                return true;
        }
    }

    public function run(): bool
    {
        foreach ($this->encounters as $encounter) {
            $success = false;
            
            while (!$success) {
                $result = $this->gameMaster->pleaseGiveMeACrit();
                if (!$this->handleOutcome($result, $encounter)) {
                    return false; // Game Over
                }
                
                if ($result === Outcome::SUCCESS || $result === Outcome::CRITICAL) {
                    $success = true;
                }
            }
        }
        
        return true; // Scénario complété avec succès
    }
} 