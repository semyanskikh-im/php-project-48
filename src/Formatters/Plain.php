<?php

namespace Differ\Formatters\Plain;

use function Functional\flatten;

function perform(array $diff): string
{
    $result = array_filter(flatten(formatPlain($diff)));
    return implode("\n", $result);
}

function formatPlain(array $diff, string $prefix = '')
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
            $prefix = ($prefix === '') ? $key : "{$prefix}.{$key}";
            $diff['key'] = $prefix;
            return array_map(
                function ($child) use ($prefix) {
                    return formatPlain($child, $prefix);
                },
                $diff['children']
            );


        case 'added':
            $diff['key'] = ($prefix === '') ? $key : "{$prefix}.{$key}";
            $value = stringify($diff['value']);
            return "Property '{$diff['key']}' was added with value: {$value}";

        case 'unchanged':
            return;

        case 'removed':
            $diff['key'] = ($prefix === '') ? $key : "{$prefix}.{$key}";
            return "Property '{$diff['key']}' was removed";

        case 'updated':
            $diff['key'] = ($prefix === '') ? $key : "{$prefix}.{$key}";
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
    } elseif (is_object($data)) {
        return '[complex value]';
    }

    $failure = gettype($data);
    throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}
