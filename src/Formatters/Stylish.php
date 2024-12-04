<?php

namespace Differ\Formatters\Stylish;

function makeIndent($depth)
{
    $step = 4;
    $backStep = 2;
    $indent = $depth * $step - $backStep;
    return str_repeat(' ', $indent);
}

function stringify($data, $depth = 1)
{
    if (is_string($data)) {
        return $data;
    } elseif (is_numeric($data)) {
        return (string) $data;
    } elseif (is_bool($data)) {
        return $data ? 'true' : 'false';
    } elseif (is_null($data)) {
        return 'null';
    } elseif (is_array($data)) {
        $keys = array_keys($data);

        $preview = array_map(
            function ($key) use ($data, $depth) {
                return makeIndent($depth + 1) . "  " . $key . ": " . stringify($data[$key], $depth + 1);
            },
            $keys
        );

        $result = implode("\n", $preview);
        return "{" . PHP_EOL . $result . PHP_EOL . makeIndent($depth) . "  }";
    }

    $failure = getType($data);
    throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}

function formatStylish(array $diff, $depth = 1)
{
    $status = $diff['status'];
    $key = $diff['key'] ?? null;
    $indent = makeIndent($depth);

    switch ($status) {
        case 'root':
            $result = array_map(
                function ($node) {
                    return formatStylish($node);
                },
                $diff['children']
            );
            return implode("\n", $result);

        case 'added':
            return $indent . "+ " . $key . ": " . stringify($diff['value'], $depth);

        case 'removed':
            return $indent . "- " . $key . ": " . stringify($diff['value'], $depth);

        case 'unchanged':
            return $indent . "  " . $key . ": " . stringify($diff['value'], $depth);

        case 'updated':
            return $indent . "- " . $key . ": " . stringify($diff['value1'], $depth) . PHP_EOL
            . $indent . "+ " . $key . ": " . stringify($diff['value2'], $depth);

        case 'have children':
            $result = array_map(
                function ($child) use ($depth) {
                    return formatStylish($child, $depth + 1);
                },
                $diff['children']
            );
            $prefinal = implode("\n", $result);
            return "$indent  $key: {\n{$prefinal}\n$indent  }";

        default:
            throw new \Exception('Unknown status');
    }
}

function makeStylish($diff)
{
    $result = formatStylish($diff);
    return "{\n{$result}\n}";
}
