<?php

namespace Lib\Persistence\File\Driver;

use Lib\File\File;

interface FileReadingDriver
{
    public function supports(File $sourceFile) : bool;

    public function extractData(File $sourceFile) : iterable;
}
