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

        $pathInfo = pathinfo($this->filePath);
        $this->dirname = $pathInfo['dirname'];
        $this->basename = $pathInfo['basename'];
        $this->filename = $pathInfo['filename'];
        $this->extension = $pathInfo['extension'] ?? '';
    }

    public function getFullPath(): string
    {
        return $this->filePath;
    }
}
