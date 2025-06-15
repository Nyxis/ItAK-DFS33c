<?php

namespace Lib\Persistence\File;

use Lib\File\File;

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
