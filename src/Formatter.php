<?php

namespace Differ\Formatters;

function format(array $diff, string $format): string
{
    switch ($format) {
        case 'plain':
            return Plain\perform($diff);
        case 'stylish':
            return Stylish\perform($diff);
        case 'json':
            return Json\perform($diff);
        default:
            throw new \Exception("Unknown format '{$format}'.");
    }
}
