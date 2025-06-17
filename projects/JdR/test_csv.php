<?php

require_once __DIR__ . '/vendor/autoload.php';

use Infrastructure\FileDatastore;
use Infrastructure\CsvFileReader;
use Lib\File\File;

try {
    $filePath = __DIR__ . '/data/equipments.csv';
    echo "Tentative de lecture du fichier : {$filePath}\n";
    
    if (!file_exists($filePath)) {
        throw new \RuntimeException("Le fichier n'existe pas : {$filePath}");
    }
    
    $file = new File($filePath);
    echo "Fichier créé avec succès. Extension : {$file->extension}\n";
    
    $reader = new CsvFileReader();
    echo "Vérification de l'acceptation du fichier...\n";
    if (!$reader->accepts($file)) {
        throw new \RuntimeException("Le lecteur CSV n'accepte pas le fichier : {$file->extension}");
    }
    
    $datastore = new FileDatastore($file, [$reader]);
    echo "Lecture des données...\n";
    
    $data = $datastore->loadData();
    echo "Contenu du fichier equipments.csv :\n";
    echo "--------------------------------\n";
    foreach ($data as $item) {
        echo json_encode($item, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
    }
} catch (\Exception $e) {
    echo "ERREUR : " . $e->getMessage() . "\n";
    echo "Dans le fichier : " . $e->getFile() . " à la ligne " . $e->getLine() . "\n";
} 