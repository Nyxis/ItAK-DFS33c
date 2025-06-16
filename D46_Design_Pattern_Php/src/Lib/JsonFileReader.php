<?php

namespace Lib;

class JsonFileReader implements FileReader
{
    private ?File $file = null;

    public function accepts(File $file): bool
    {
        return strtolower($file->getExtension()) === 'json';
    }

    public function setFile(File $file): void
    {
        $this->file = $file;
    }

    public function read(): array
    {
        if ($this->file === null) {
            throw new \RuntimeException("No file set for reading");
        }

        if (!$this->file->exists()) {
            throw new \RuntimeException("File not found: {$this->file->getPath()}");
        }

        $content = file_get_contents($this->file->getPath());
        if ($content === false) {
            throw new \RuntimeException("Unable to read file: {$this->file->getPath()}");
        }

        // Suppression de la vérification/conversion d'encodage
        $data = json_decode($content, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("Invalid JSON in file: {$this->file->getPath()} - " . json_last_error_msg());
        }

        return $data;
    }
} 