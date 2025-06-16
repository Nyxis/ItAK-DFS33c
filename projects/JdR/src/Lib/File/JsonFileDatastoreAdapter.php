<?php

namespace Lib\File;

use Lib\Datastore;

class JsonFileDatastoreAdapter implements Datastore
{
    private ?array $cachedData = null;

    public function __construct(
        private JsonFileReader $reader
    ) {}

    public function loadData(): array
    {
        if ($this->cachedData === null) {
            $this->cachedData = $this->reader->parse();
        }

        return $this->cachedData;
    }
}
