<?php

namespace Differ\Formatter;

use Exception;
use PhpParser\Node\Expr\Throw_;

use function Differ\Formatters\Stylish\makeStylish;

function formatter($diff, $format)
{
    switch ($format) {
        // case 'plain':
            //return makePlain($diff);
        case 'stylish':
            return makeStylish($diff);
        default:
            throw new \Exception('Unknown format');
    }
}
