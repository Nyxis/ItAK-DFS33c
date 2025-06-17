<?php

namespace Infrastructure;

use Lib\File\File;

interface FileReader
{
    public function accepts(File $file): bool;
    public function read(File $file): array;
} 