<?php
require_once __DIR__ . '/vendor/autoload.php';

$regex = new App\Text\Replace();

echo $regex->searchAndReplace("Ankara'nın Ankara ya faydası", 'ankara', 'samsun').PHP_EOL;
echo $regex->searchAndReplace("Armut un iyisini ayılar yer", 'armut', 'elma').PHP_EOL;
echo $regex->searchAndReplace("tatil'e Mersin e gittim", 'mersin', 'hatay').PHP_EOL;
