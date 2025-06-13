<?php

namespace Lib\File;

class File
{
    public readonly string $dirname;
    public readonly string $basename;
    public readonly string $extension;
    public readonly string $filename;

    public function __construct(
        private string $filePath
    ) {
        if (!is_readable($this->filePath)) {
            throw new \InvalidArgumentException(sprintf(
                'Unreadable file; looked at "%s"',
                $this->filePath
            ));
        }

        foreach(pathinfo($this->filePath) as $key => $value) {
            if (!property_exists($this, $key)) {
                continue;
            }

            $this->$key = $value;
        }
    }
}
