<?php

namespace Infrastructure;

use Lib\Datastore;

class JsonFileReader implements Datastore
{
    public function __construct(
        private string $filePath
    ) {
        if (!file_exists($this->filePath) || !is_readable($this->filePath)) {
            throw new \InvalidArgumentException("File not found or not readable: {$this->filePath}");
        }
    }

    public function loadData(): array
    {
        // Lire le contenu du fichier
        $jsonContent = file_get_contents($this->filePath);
        
        if ($jsonContent === false) {
            throw new \RuntimeException("Failed to read file: {$this->filePath}");
        }

        // Décoder le JSON avec gestion d'erreur
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException("Invalid JSON in file: {$this->filePath}. Error: " . json_last_error_msg());
        }
        
        if ($data === null) {
            throw new \RuntimeException("Failed to decode JSON from file: {$this->filePath}");
        }

        return $data;
    }
} 