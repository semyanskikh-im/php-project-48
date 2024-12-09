<?php

namespace Differ\Formatter;

use Exception;
use PhpParser\Node\Expr\Throw_;

use function Differ\Formatters\Stylish\makeStylish;
use function Differ\Formatters\Plain\makePlain;
use function Differ\Formatters\Json\makeJson;

function formatter(array $diff, string $format): string
{
    switch ($format) {
        case 'plain':
            return makePlain($diff);
        case 'stylish':
            return makeStylish($diff);
        case 'json':
            return makeJson($diff);
        default:
            throw new \Exception('Unknown format');
    }
}
