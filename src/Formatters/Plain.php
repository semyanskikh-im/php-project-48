<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function makePlain(array $diff): string
{
    $result = array_filter(flatten(formatPlain($diff)));
    return implode("\n", $result);
}

function formatPlain(array $diff, string $acc = '')
{
    $status = $diff['status'];
    $key = $diff['key'] ?? null;

    switch ($status) {
        case 'root':
            return array_map(
                function ($node) {
                    return formatPlain($node);
                },
                $diff['children']
            );

        case 'have children':
            $acc = ($acc === '') ? $key : $acc . "." . $key;
            $diff['key'] = $acc;
            return array_map(
                function ($child) use ($acc) {
                    return formatPlain($child, $acc);
                },
                $diff['children']
            );


        case 'added':
            $diff['key'] = ($acc === '') ? $key : $acc . "." . $key;
            $value = stringify($diff['value']);
            return "Property '{$diff['key']}' was added with value: {$value}";

        case 'unchanged':
            return;

        case 'removed':
            $diff['key'] = ($acc === '') ? $key : $acc . "." . $key;
            $value = stringify($diff['value']);
            return "Property '{$diff['key']}' was removed";

        case 'updated':
            $diff['key'] = ($acc === '') ? $key : $acc . "." . $key;
            $value1 = stringify($diff['value1']);
            $value2 = stringify($diff['value2']);
            return "Property '{$diff['key']}' was updated. From {$value1} to {$value2}";

        default:
            throw new \Exception('Unknown status');
    }
}


function stringify(mixed $data): string
{
    if (is_string($data)) {
        return "'$data'";
    } elseif (is_numeric($data)) {
        return (string) $data;
    } elseif (is_bool($data)) {
        return $data ? 'true' : 'false';
    } elseif (is_null($data)) {
        return 'null';
    } elseif (is_array($data)) {
        return '[complex value]';
    }

    $failure = getType($data);
    throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}
