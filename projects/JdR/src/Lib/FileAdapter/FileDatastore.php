<?php

namespace Lib\FileAdapter;

use Lib\File\File;

class FileDatastore
{
    public function __construct(
        //Fichier à read.
        private readonly File $file,
        //Lecteurs
        private readonly array $readers
    ) {}

    public function read(File $file): array
    {
        //Read fichier avec le bon lecteur:
        foreach ($this->readers as $reader) {
            if($reader ->accepts($file)){
                return $reader->read($file);
            }
        }
        throw new \RuntimeException(('unavailable file fo readers for this extension'));
    }
}
