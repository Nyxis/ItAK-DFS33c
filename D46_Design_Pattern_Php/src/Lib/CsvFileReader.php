<?php

namespace Lib;

class CsvFileReader implements FileReader
{
    private ?File $file = null;

    public function accepts(File $file): bool
    {
        return strtolower($file->getExtension()) === 'csv';
    }

    public function setFile(File $file): void
    {
        $this->file = $file;
    }

    public function read(): array
    {
        if ($this->file === null) {
            throw new \RuntimeException("No file set for reading");
        }

        if (!$this->file->exists()) {
            throw new \RuntimeException("File not found: {$this->file->getPath()}");
        }

        $data = [];
        if (($handle = fopen($this->file->getPath(), "r")) !== false) {
            // Read headers
            $headers = fgetcsv($handle);
            if ($headers === false) {
                throw new \RuntimeException("Invalid CSV file: {$this->file->getPath()}");
            }

            // Read data rows
            while (($row = fgetcsv($handle)) !== false) {
                $data[] = array_combine($headers, $row);
            }
            fclose($handle);
        }

        return $data;
    }
} 