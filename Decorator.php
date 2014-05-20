<?php

require_once "Spyc.php";

$dir = 'entities/';
$sourceDir = 'newEntities/';
$extension = 'orm.yml';
$pathEntity = 'Dcl\DclBundle\Entity\\';
//$pathEntity = '';

$files = scandir($dir);
unset($files[0]); unset($files[1]);

foreach ($files as $file) {

    $data = Spyc::YAMLLoad($dir.$file);
    $fileName = basename($file, '.'.$extension);
    $entity = substr($fileName, 4);

    $data[$pathEntity.$entity] = $data[$pathEntity.$fileName];
    unset($data[$pathEntity.$fileName]);

    //change pk in id
    if (isset($data[$pathEntity.$entity]['id'][lcfirst($entity).'Pk'])) {
        $data[$pathEntity.$entity]['id']['id'] = $data[$pathEntity.$entity]['id'][lcfirst($entity).'Pk'];
        unset($data[$pathEntity.$entity]['id'][lcfirst($entity).'Pk']);
    }

    if (isset($data[$pathEntity.$entity]['fields'])) {
        $newFields = array();
        foreach ($data[$pathEntity.$entity]['fields'] as $key => $field) {
            //var_dump(strcmp(lcfirst($entity), substr($key, 0, strlen($entity))));
            if (!strcmp(lcfirst($entity), $key) || 
                strcmp(lcfirst($entity), substr($key, 0, strlen($entity)))) {
                $newFields[$key] = $field;
                continue;
            }

            $newKey = lcfirst(substr($key, strlen($entity)));
            $newFields[$newKey] = $field;
        }

        $data[$pathEntity.$entity]['fields'] = $newFields;
    }

    $newFile = $sourceDir.$entity.'.'.$extension;
    $fileContent = Spyc::YAMLDump($data);
    $fileContent = substr($fileContent, 4);
    file_put_contents($newFile, $fileContent);

    echo $fileName.'..................................... done <br>';
}

echo "done <br>";