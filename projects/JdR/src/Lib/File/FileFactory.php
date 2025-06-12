<?php

namespace Lib\File;

use Lib\StructuredFile;

class FileFactory
{
    public static function create(string $filePath): StructuredFile
    {
        $pathInfo = pathinfo($filePath);
        $extension = $pathInfo['extension'] ?? '';

        return match(strtolower($extension)) {
            'json' => new JsonFile($filePath),
            default => throw new \InvalidArgumentException("Unsupported file type: {$extension}")
        };
    }
} 