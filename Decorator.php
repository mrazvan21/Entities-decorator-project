<?php

require_once "Spyc.php";

$dir = 'entities/';
$sourceDir = 'newEntities/';

$files = scandir($dir);
unset($files[0]); unset($files[1]);

foreach ($files as $file) {

    $data = Spyc::YAMLLoad($dir.$file);
	$fileName = basename($file, ".orm.yml");
	$entity = substr($fileName, 4);

	$data[$entity] = $data[$fileName];
	unset($data[$fileName]);

	//change pk in id
	/*$data[$entity]['id']['id'] = $data[$entity]['id'][lcfirst($entity).'Pk'];
	unset($data[$entity]['id'][lcfirst($entity).'Pk']);*/

	$newFields = array();
	foreach ($data[$entity]['fields'] as $key => $field) {
		$newKey = lcfirst(substr($key, strlen($entity)));
		$newFields[$newKey] = $field;
	}

	$data[$entity]['fields'] = $newFields;

	$newFile = $sourceDir.$entity.'.yml';
	$fileContent = Spyc::YAMLDump($data);
	$fileContent = substr($fileContent, 4);
	file_put_contents($newFile, $fileContent);

    echo $fileName.'..................................... done <br>';
}

echo "done <br>";