<?php

namespace Lib\File;

use Lib\Datastore;

class JsonFileDatastoreAdapter implements Datastore
{
    private array $data;

    public function __construct(
        private JsonFileReader $reader
    ) {
        $this->data = $this->reader->parse(); // lecture immédiate à la construction

        if (empty($this->data)) {
            throw new \RuntimeException("Le fichier JSON est vide ou invalide.");
        }
    }

    public function loadData(): array
    {
        return $this->data; // retour direct du cache
    }
}
