<?php

namespace Lib\Persistence\File;
use Lib\File\File;
use Lib\FileReader;
use Lib\Persistence\Datasource;

/**
 * @see array_find
 */
class FileDatasource implements Datasource
{
    private /* ... */ $driver;

    public function __construct(
        private File $sourceFile,
        private FileDatastore $driver
    ){
    }

    public function loadAll() : \Iterator
    {
        
        yield from $this->driver->read($this-sourceFile);
    }
}