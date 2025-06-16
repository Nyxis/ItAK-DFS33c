<?php

namespace Lib\File;

use Lib\StructuredFile;

class JsonFileReader implements StructuredFile
{
    public function __construct(
        private string $filePath
    ) {}

    public function parse(): array
    {
        if (!file_exists($this->filePath)) {
            throw new \RuntimeException("Fichier introuvable : {$this->filePath}");
        }

        $jsonContent = file_get_contents($this->filePath);

        if (empty($jsonContent)) {
            throw new \RuntimeException("Le fichier JSON est vide : {$this->filePath}");
        }

        $data = json_decode($jsonContent, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \InvalidArgumentException("JSON invalide dans {$this->filePath} : " . json_last_error_msg());
        }

        return $data;
    }
}
