<?php

namespace Differ\Parsers;

use Symfony\Component\Yaml\Yaml;

/*
 * функция парсит содержиоме json или yaml файла и декодирует строку в объект
 */
function parse(string $fileContent, string $fileExtension): object
{
    return match ($fileExtension) {
        'json' => json_decode($fileContent),// декодируем из json в Std:Class Object

        'yaml', 'yml' => Yaml::parse($fileContent, Yaml::PARSE_OBJECT_FOR_MAP),// декодирум из yaml/yml Std:Class Object

        default => throw new \Exception("This utility can't work with .{$fileExtension} extension.")
    };
}
