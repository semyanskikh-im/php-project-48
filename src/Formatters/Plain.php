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
            $fullPath = ($prefix === '') ? $key : "{$prefix}.{$key}";
            return array_map(
                function ($child) use ($fullPath) {
                    return formatPlain($child, $fullPath);
                },
                $diff['children']
            );


        case 'added':
            $fullPath = ($prefix === '') ? $key : "{$prefix}.{$key}";
            $value = stringify($diff['value']);
            return "Property '{$fullPath}' was added with value: {$value}";

        case 'unchanged':
            return;

        case 'removed':
            $fullPath = ($prefix === '') ? $key : "{$prefix}.{$key}";
            return "Property '{$fullPath}' was removed";

        case 'updated':
            $fullPath = ($prefix === '') ? $key : "{$prefix}.{$key}";
            $value1 = stringify($diff['value1']);
            $value2 = stringify($diff['value2']);
            return "Property '{$fullPath}' was updated. From {$value1} to {$value2}";

        default:
            throw new \Exception("Unknown status '{$status}'");
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
