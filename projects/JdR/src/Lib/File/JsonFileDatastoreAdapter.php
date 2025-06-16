<?php

namespace Lib\File;

use Lib\Datastore;

class JsonFileDatastoreAdapter implements Datastore
{
    private array $cachedData;

    public function __construct(
        private JsonFileReader $reader
    ) {
        $this->cachedData = $this->reader->parse();

        if (!is_array($this->cachedData)) {
            throw new \RuntimeException("Erreur : le fichier JSON ne contient pas de tableau valide.");
        }

        // Optionnel : empêcher un fichier vide
        if (empty($this->cachedData)) {
            throw new \RuntimeException("Erreur : le fichier JSON est vide.");
        }
    }

    public function loadData(): array
    {
        return $this->cachedData;
    }
}
