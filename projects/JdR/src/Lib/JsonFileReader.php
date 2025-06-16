<?php

namespace Lib;

class JsonFileReader
{
    public function __construct(
        private readonly string $filePath
    ) {}

    public function read(): array
    {
        $content = file_get_contents($this->filePath);
        if (!json_validate($content)) {
            throw new \RunTimeException('JSON fil invalid');
        }
        return json_decode($content, true);
    }
}
