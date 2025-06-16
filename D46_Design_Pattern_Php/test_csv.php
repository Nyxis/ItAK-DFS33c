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

$file = new File(__DIR__ . '/../projects/JdR/data/equipments.csv');
$datastore = new FileDatastore($file, new JsonFileReader(), new CsvFileReader());

$data = $datastore->loadData();

echo "Contenu du fichier equipments.csv :\n";
foreach ($data as $row) {
    echo "------------------------\n";
    foreach ($row as $key => $value) {
        echo "$key: $value\n";
    }
} 