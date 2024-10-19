<?php

namespace GenerateDiff\Parser;

function parse($path) 
{
    $fileContent = file_get_contents($path);
    if (!empty($fileContent)) {
        return json_decode($fileContent, true);
    } else {
        echo 'File is empty' . PHP_EOL;
    }
}