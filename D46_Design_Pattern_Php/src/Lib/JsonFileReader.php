<?php

namespace Lib;

class JsonFileReader
{
    private string $filePath;

    public function __construct(string $filePath)
    {
        $this->filePath = $filePath;
    }

    public function read(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \RuntimeException("File not found: {$this->filePath}");
        }

        $content = file_get_contents($this->filePath);
        if ($content === false) {
            throw new \RuntimeException("Could not read file: {$this->filePath}");
        }

        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON: " . json_last_error_msg());
        }

        return $data;
    }
} 