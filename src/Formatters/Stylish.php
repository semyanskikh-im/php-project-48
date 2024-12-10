<?php

namespace Differ\Formatters\Stylish;

function makeIndent(int $depth): string
{
    $step = 4;
    $backStep = 2;
    $indent = $depth * $step - $backStep;
    return str_repeat(' ', $indent);
}

function stringify(mixed $data, int $depth = 1): string
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
                $indent = makeIndent($depth + 1);
                $value = stringify($data[$key], $depth + 1);
                return "$indent  $key: $value";
            },
            $keys
        );

        $result = implode("\n", $preview);
        $closingIndent = makeIndent($depth);
        return "{\n$result\n$closingIndent  }";
    }

    $failure = getType($data);
    throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}

function formatStylish(array $diff, int $depth = 1): string
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
            $value = stringify($diff['value'], $depth);
            return "$indent+ $key: $value";
        case 'removed':
            $value = stringify($diff['value'], $depth);
            return "$indent- $key: $value";

        case 'unchanged':
            $value = stringify($diff['value'], $depth);
            return "$indent  $key: $value";

        case 'updated':
            $value1 = stringify($diff['value1'], $depth);
            $value2 = stringify($diff['value2'], $depth);
            return "$indent- $key: $value1\n$indent+ $key: $value2";

        case 'have children':
            $result = array_map(
                function ($child) use ($depth) {
                    return formatStylish($child, $depth + 1);
                },
                $diff['children']
            );
            $prefinal = implode("\n", $result);
            return "$indent  $key: {\n$prefinal\n$indent  }";

        default:
            throw new \Exception('Unknown status');
    }
}

function makeStylish(array $diff): string
{
    $result = formatStylish($diff);
    return "{\n$result\n}";
}
