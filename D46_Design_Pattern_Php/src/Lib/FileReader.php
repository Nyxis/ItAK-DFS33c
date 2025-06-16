<?php

namespace Lib;

interface FileReader
{
    /**
     * Check if this reader can handle the given file
     * @param File $file
     * @return bool
     */
    public function accepts(File $file): bool;

    /**
     * Read and parse the file content
     * @return array
     */
    public function read(): array;
} 