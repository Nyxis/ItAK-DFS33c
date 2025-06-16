<?php

namespace Lib\File;

class JsonFileReader
{
    public function __construct(
        private string $filepath
    ) {}

    public function read(): string
    {
        if (!file_exists($this->filepath)) {
            throw new \RuntimeException("File not found: {$this->filepath}");
        }

        return file_get_contents($this->filepath);
    }

    public function parse(): array
    {
        $json = $this->read();

        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON: ".json_last_error_msg());
        }

        return $data;
    }
}
