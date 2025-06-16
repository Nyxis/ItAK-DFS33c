<?php

require_once __DIR__ . '/src/Lib/Datastore.php';
require_once __DIR__ . '/src/Lib/File.php';
require_once __DIR__ . '/src/Lib/FileReader.php';
require_once __DIR__ . '/src/Lib/JsonFileReader.php';
require_once __DIR__ . '/src/Lib/CsvFileReader.php';
require_once __DIR__ . '/src/Lib/FileDatastore.php';

use Lib\File;
use Lib\JsonFileReader;
use Lib\CsvFileReader;
use Lib\FileDatastore;

$file = new File(__DIR__ . '/../projects/JdR/data/scenarios.json');
echo "Chemin du fichier : " . $file->getPath() . "\n";
echo "Extension du fichier : " . $file->getExtension() . "\n";
echo "Le fichier existe : " . ($file->exists() ? "Oui" : "Non") . "\n";

$jsonReader = new JsonFileReader();
echo "Le lecteur JSON accepte le fichier : " . ($jsonReader->accepts($file) ? "Oui" : "Non") . "\n";

$datastore = new FileDatastore($file, new JsonFileReader(), new CsvFileReader());

try {
    $data = $datastore->loadData();
    echo "\nContenu du fichier scenarios.json :\n";
    foreach ($data as $scenario) {
        echo "\n========================\n";
        echo "Titre: " . $scenario['title'] . "\n";
        
        if (isset($scenario['encounters'])) {
            echo "\nRencontres:\n";
            foreach ($scenario['encounters'] as $encounter) {
                echo "------------------------\n";
                echo "Titre: " . $encounter['title'] . "\n";
                echo "Description: " . $encounter['flavor'] . "\n";
                if (isset($encounter['results'])) {
                    echo "Résultats possibles:\n";
                    echo "- Succès: " . ($encounter['results']['success'] ?? 0) . "%\n";
                    echo "- Échec: " . ($encounter['results']['failure'] ?? 0) . "%\n";
                    echo "- Échec critique: " . ($encounter['results']['fumble'] ?? 0) . "%\n";
                }
            }
        }
    }
} catch (\Exception $e) {
    echo "Erreur : " . $e->getMessage() . "\n";
} 