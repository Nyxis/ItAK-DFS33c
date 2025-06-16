<?php

namespace Module\Character\Model;

use Lib\ValueObject\PositiveInt;

class Character
{
    protected $level;
    protected array $stuff = [];

    protected int $maxHealth;

    /**
     * Current health of the character.
     */
    protected int $currentHealth = 0;

    /**
     * Get the character's power.
     */
    public function getPower(): int
    {
        return max(
            0,   // cannot have negative power
            array_sum([
                $this->level,
                count($this->stuff),
                -floor(($this->maxHealth - $this->currentHealth) / 2)
            ])
        );
    }

    public function __construct(
        public readonly string $name,
        PositiveInt $baseHealth,
        PositiveInt $level = new PositiveInt(1),
    ) {
        $this->maxHealth = $baseHealth->value;
        $this->currentHealth = $this->maxHealth;
        $this->level = $level->value;
    }

    public function isAlive() : bool
    {
        return $this->currentHealth > 0;
    }

    public function heal(PositiveInt $healingPower = new PositiveInt(1)) : void
    {
        $this->setCurrentHealth($healingPower->value);
    }

    public function hurt(PositiveInt $nbWounds = new PositiveInt(1)) : void
    {
        $this->setCurrentHealth(-$nbWounds->value);
    }

    /**
     * Safely set current health, ensuring it stays within valid bounds.
     */
    protected function setCurrentHealth(int $delta): void
    {
        $this->currentHealth = max(
            0,
            min($this->maxHealth, $this->currentHealth + $delta)
        );
    }

    /**
     * Level up the character by a given number of levels.
     */
    public function levelUp(PositiveInt $nbLevels = new PositiveInt(1)) : void
    {
        $this->level += $nbLevels->value;
        // raccourci pour : $this->level = $this->level + $nbLevel;

        $this->maxHealth += $nbLevels->value;
        $this->heal($nbLevels);
    }

    public function loot($equipment)
    {
        $this->stuff[] = $equipment;
    }

    public function __toString() : string
    {
        return $this->isAlive() ?
            sprintf(
                "%s lv.%s %s/%s♥️  %s💪",
                str_pad($this->name, 16),
                str_pad($this->level, 2),
                str_pad($this->currentHealth, 2, ' ', STR_PAD_LEFT),
                $this->maxHealth,
                str_pad($this->getPower(), 2, ' ', STR_PAD_LEFT)
            ) :
            str_pad(sprintf("%s 💀", str_pad($this->name, 18)), 37)
        ;
    }
}
