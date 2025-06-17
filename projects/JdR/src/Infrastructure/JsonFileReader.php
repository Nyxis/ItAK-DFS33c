<?php

namespace Infrastructure;

use Lib\File\File;

class JsonFileReader implements FileReader
{
    public function accepts(File $file): bool
    {
        return strtolower($file->extension) === 'json';
    }

    public function read(File $file): array
    {
        $fullPath = $file->dirname . DIRECTORY_SEPARATOR . $file->basename;
        
        // Lire le contenu du fichier
        $jsonContent = file_get_contents($fullPath);
        
        if ($jsonContent === false) {
            throw new \RuntimeException("Failed to read file: {$fullPath}");
        }

        // Décoder le JSON avec gestion d'erreur
        $data = json_decode($jsonContent, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException("Invalid JSON in file: {$fullPath}. Error: " . json_last_error_msg());
        }
        
        if ($data === null) {
            throw new \RuntimeException("Failed to decode JSON from file: {$fullPath}");
        }

        return $data;
    }
} 