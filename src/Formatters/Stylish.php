<?php

namespace GenerateDiff\Formatters\Stylish;

function formatStylish($diff)
{
            $result = array_map(function($item) {

                $dip = $item['depth']; //текущая глубина
                $count = $dip * 4 - 2;//формула расчета отступа в зависимости от глубины
                $indent = str_repeat(".", $count);// сколько раз повторяем отступ
                $status = $item['status'];
                $key = $item['key'];
                switch ($status) {

                case 'added':
                    $data = "+ {$key}: ";
                    break;
                case 'removed':
                    $data = "- {$key}: ";
                    break;
                case 'unchanged':
                    $data = "  {$key}: ";
                    break;
                case 'updated':
                    $data1 = "- {$key}: ";
                    $data2 = "+ {$key}: ";
                    break;
                default:
                    throw new \Exception('Unknown status');   
                }
     
        if (!$status = 'updated' && !is_array($item['value'])) {//если не построены дети
            $lines = "{$indent}{$data}{$item['value']}\n";
            return $lines;
        }
        if (!$status = 'updated' && is_array($item['value'])) {//если у значения есть дети
        
            $lines[] = "{$indent}{$data}{\n";
            formatStylish($item['value']);
            $lines[] = "{$indent}}\n";
            return $lines;
            }
        if ($status = 'updated') {
            $lines[] = "{$indent}{$data1}{$item['value1']}\n";
            $lines[] = "{$indent}{$data2}{$item['value2']}\n";
            return $lines;
        }
        }, $diff);

        $preView = implode($result);
        $finalView = "{\n{$preView}}\n";

    return $finalView;
}

