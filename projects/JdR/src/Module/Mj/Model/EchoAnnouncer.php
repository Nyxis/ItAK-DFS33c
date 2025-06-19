<?php

namespace Module\Mj\Model;

class EchoAnnouncer implements Announcer
{
    public function announce(string $message): void
    {
        echo $message . "\n";
    }
}