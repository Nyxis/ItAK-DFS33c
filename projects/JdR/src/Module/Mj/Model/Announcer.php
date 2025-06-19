<?php

namespace Module\Mj\Model;

interface Announcer
{
    public function announce(string $message): void;
}
