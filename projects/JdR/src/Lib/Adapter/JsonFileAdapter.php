<?php

namespace Lib\Adapter;

use Lib\DataStore;
use Lib\JsonFileReader;

class JsonFileDatastoreAdapter implements DataStore
{
    // ajout chargement unique à la demande
    private ?array $memoryData = null;

    public function __construct(
        private readonly JsonFileReader $reader
    ) {}

    public function loadData(): array
    {
        if ($this->memoryData === null) {
            $this->memoryData = $this->reader->read();
        }
        return $this->memoryData;
    }
}
