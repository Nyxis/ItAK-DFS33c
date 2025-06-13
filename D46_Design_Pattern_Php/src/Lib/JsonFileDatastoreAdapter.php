<?php

namespace Lib;

class JsonFileDatastoreAdapter implements Datastore
{
    private ?array $cachedData = null;
    private JsonFileReader $reader;

    public function __construct(JsonFileReader $reader)
    {
        $this->reader = $reader;
    }

    public function loadData(): array
    {
        if ($this->cachedData === null) {
            $this->cachedData = $this->reader->read();
        }

        return $this->cachedData;
    }
} 