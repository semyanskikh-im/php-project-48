<?php

namespace Differ\Formatters\Stylish;

function makeIndent($depth = 1)
{
	$step = 4;
  $backStep = 2;
  $indent = $depth * $step - $backStep;
	return str_repeat('.', $indent);
	
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
  	foreach ($data as $key => $value) {
  		if (is_array($value)) {//если значение - тоже массив, то проваливаемся на уровень ниже
  			$output[] = makeIndent($depth) . stringify($key) . ": {" . PHP_EOL . stringify($value, $depth + 1);
  			
  			$output[] = makeIndent($depth) . "}";// закрываем текщий уровень скобкой
  			}
  		if(!is_array($value)) {//если значение не массив, то просто формируем строку
  			$output[] = PHP_EOL . makeIndent($depth + 1) . stringify($key) . ": " . stringify($value);
  		}	
    } 
    
    $result = implode("\n", $output);
    return $result;
  }

  $failure = getType($data);
  Throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}


function formatStylish($diff, $depth = 1)
{
            $result = array_map(function($item) use ($depth) {

                $status = $item['status'];
                $key = stringify($item['key']);
                $indent = makeIndent($depth);

                switch ($status) {

                case 'added':
                    return $indent . "+ " . $key . ": " . stringify($item['value'], $depth);
                    
                case 'removed':
                    return $indent . "- " . $key . ": " . stringify($item['value'], $depth);

                case 'unchanged':
                  return $indent . "  " . $key . ": " . stringify($item['value'], $depth);

                case 'updated':
                  return $indent . "- " . $key . ": " . stringify($item['value1'], $depth) . PHP_EOL 
                  . $indent . "+ " . $key . ": " . stringify($item['value2'], $depth);

                case 'have children':
                    return $indent . "  " . $key . ": {" . PHP_EOL . formatStylish($item['value'], $depth + 1) . PHP_EOL 
                    . $indent . "}";
                  
                default:
                    throw new \Exception('Unknown status');   
                }
              }, $diff);
          return implode("\n", $result);
            }
     
    

