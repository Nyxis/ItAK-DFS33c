<?php

namespace Lib\Persistence\File;
use Lib\File\File;
use Lib\Persistence\Datasource;

/**
 * @see array_find
 */
class FileDatasource implements Datasource
{
    private /* ... */ $driver;

    public function __construct(
        private File $sourceFile,
        // ....... some file drivers
    ){
    }

    public function loadAll() : \Iterator
    {
        yield from $this->driver /* ... */;
    }
}