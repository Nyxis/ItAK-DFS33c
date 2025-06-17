<?php

namespace Infrastructure;

use Lib\Datastore;
use Lib\File\File;

class FileDatastore implements Datastore
{
    private ?array $cachedData = null;

    /**
     * @param File $file
     * @param FileReader[] $readers
     */
    public function __construct(
        private File $file,
        private array $readers
    ) {
    }

    public function loadData(): array
    {
        if ($this->cachedData === null) {
            foreach ($this->readers as $reader) {
                if ($reader->accepts($this->file)) {
                    $this->cachedData = $reader->read($this->file);
                    return $this->cachedData;
                }
            }
            
            throw new \RuntimeException(sprintf(
                "No reader found for file type: %s",
                $this->file->extension
            ));
        }

        return $this->cachedData;
    }
} 