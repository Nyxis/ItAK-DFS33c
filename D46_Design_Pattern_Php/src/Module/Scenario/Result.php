<?php

namespace Module\Scenario;

class Result
{
    public function __construct(
        private string $success,
        private string $failure
    ) {}

    public function getSuccess(): string
    {
        return $this->success;
    }

    public function getFailure(): string
    {
        return $this->failure;
    }
} 