<?php

namespace Module\Scenario\Model;

enum Outcome: string
{
    case FUMBLE = 'fumble';
    case FAILURE = 'failure';
    case SUCCESS = 'success';
    case CRITICAL = 'critical';

    public function toString(): string
    {
        return match ($this) {
            self::FUMBLE => '💀fumble',
            self::FAILURE => '💥échec',
            self::SUCCESS => '✨succès',
            self::CRITICAL => '⚡critique',
        };
    }
}
