<?php

namespace Infrastructure;

use Lib\Datastore;
use Lib\StructuredFile;

class JsonFileDatastoreAdapter implements Datastore
{
    private ?array $cachedData = null;

    public function __construct(
        private StructuredFile $structuredFile
    ) {
    }

    public function loadData(): array
    {
        // Chargement unique à la demande avec mise en cache
        if ($this->cachedData === null) {
            $this->cachedData = $this->structuredFile->parse();
        }

        return $this->cachedData;
    }
} 