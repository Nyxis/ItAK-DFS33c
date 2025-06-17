<?php

namespace Lib;

use Lib\File\File;

class JsonFileReader implements FileReader
{
    //Méthode Interface FileReader, ?format JSON 
    public function accepts(File $file): bool
    {
        //Evite casse majs extension du fichier
        return strtolower($file->extension) === 'json'; 
    }

    //Méthode lecture du JSON-> ?son validate
    public function read(File $file): array
    {
        $content = file_get_contents($file->filePath);
        if (!json_validate($content)) {
            throw new \RunTimeException('Invalid JSON');
        }
        return json_decode($content, true); 
    }
}
