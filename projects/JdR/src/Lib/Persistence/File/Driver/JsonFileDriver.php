<?php

namespace Lib\Persistence\File\Driver;

use Lib\File\File;

class JsonFileDriver implements FileReadingDriver
{
    public function supports(File $sourceFile) : bool
    {
        return $sourceFile->extension == '.json';
    }

    public function extractData(File $sourceFile) : iterable;
    {
        $jsonData = $this->read();
        if (!json_validate($jsonData)) {
            throw new \UnexpectedValueException(json_last_error_msg());
        }

        return json_decode(
            json: $jsonData,
            associative: true
        );
    }
}