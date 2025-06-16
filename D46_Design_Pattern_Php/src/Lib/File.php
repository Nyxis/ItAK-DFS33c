<?php

namespace Lib;

class File
{
    public function __construct(
        private string $path
    ) {}

    public function getPath(): string
    {
        return $this->path;
    }

    public function getExtension(): string
    {
        return pathinfo($this->path, PATHINFO_EXTENSION);
    }

    public function exists(): bool
    {
        return file_exists($this->path);
    }
} 