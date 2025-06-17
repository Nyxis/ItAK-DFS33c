<?php

namespace Infrastructure;

use Lib\File\File;

class CsvFileReader implements FileReader
{
    public function accepts(File $file): bool
    {
        return strtolower($file->extension) === 'csv';
    }

    public function read(File $file): array
    {
        $fullPath = $file->getFullPath();
        
        if (($handle = fopen($fullPath, "r")) === false) {
            throw new \RuntimeException("Failed to open file: {$fullPath}");
        }

        // Lire et supprimer le BOM UTF-8 si présent
        $bom = fread($handle, 3);
        if ($bom !== "\xEF\xBB\xBF") {
            // Si ce n'est pas un BOM, on revient au début du fichier
            rewind($handle);
        }

        $data = [];
        $headers = null;

        while (($row = fgetcsv($handle)) !== false) {
            // Convertir chaque élément du tableau en UTF-8
            $row = array_map(function($value) {
                return mb_convert_encoding($value, 'UTF-8', 'UTF-8');
            }, $row);

            if ($headers === null) {
                $headers = $row;
                continue;
            }

            $data[] = array_combine($headers, $row);
        }

        fclose($handle);

        return $data;
    }
} 