<?php

namespace Module\Character;

class Character
{
    private int $maxHealth;
    private int $currentHealth = 0 {
        set => max(0, min($this->maxHealth, $this->currentHealth + (int) $value));
    }
    public int $power;

    public function __construct(int $baseHealth) {
        $this->maxHealth = $baseHealth;
        $this->currentHealth = $this->maxHealth;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(int $amount = 1) : void
    {
        $this->currentHealth = $amount;
    }

    public function hurt(int $amount = 1) : void
    {
        $this->currentHealth = -$amount;
    }
}
