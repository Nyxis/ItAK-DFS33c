<?php

namespace Lib;

class FileDatastore implements Datastore
{
    private ?array $cachedData = null;
    private File $file;
    private array $readers;

    public function __construct(File $file, FileReader ...$readers)
    {
        $this->file = $file;
        $this->readers = $readers;
    }

    public function loadData(): array
    {
        if ($this->cachedData === null) {
            foreach ($this->readers as $reader) {
                if ($reader->accepts($this->file)) {
                    $reader->setFile($this->file);
                    $this->cachedData = $reader->read();
                    return $this->cachedData;
                }
            }
            throw new \RuntimeException("No suitable reader found for file: {$this->file->getPath()}");
        }

        return $this->cachedData;
    }
} 