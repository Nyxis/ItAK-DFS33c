<?php

namespace Lib\FileAdapter;

use Lib\File\File;

class FileDatastore
{
    private ?array $memoryData = null;

    public function __construct(
        private readonly File $file,
        private readonly array $readers
    ) {}

    public function read(File $file): array
    {
        foreach ($this->readers as $reader) {
            if($reader ->accepts($file)){
                return $reader->read($file);
            }
        }
        throw new \RuntimeException(('unavailable file fo readers'));
    }
}
