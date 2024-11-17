<?php

namespace Differ\Formatters\Stylish;

function makeIndent($symbol, $depth)
{
	$indent = $depth * 4 - 2;
	if ($indent > 0) {
		return str_repeat($symbol, $indent);
	}
	return '';
}

function stringifyIter($data, $symbol = '.', $depth = 1) 
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
  	foreach ($data as $key => $value) {
  		if (is_array($value)) {
  			$output[] = makeIndent($symbol, $depth) . stringifyIter($key) . ": {" . PHP_EOL . stringifyIter($value, $symbol, $depth + 1);
  			
  			$output[] = makeIndent($symbol, $depth) . "}";
  			}
  		if(!is_array($value)) {
  			$output[] = makeIndent($symbol, $depth) . stringifyIter($key) . ": " . stringifyIter($value);
  		}	
  	}
  	   
  	   return implode("\n", $output);
  	   
  }
    
  $failure = getType($data);
  Throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}


function formatStylish($diff)
{
            $result = array_map(function($item) {

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

