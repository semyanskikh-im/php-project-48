<?php

namespace Differ\Formatters\Stylish;

function makeSmallIndent($depth = 1)
{
	$step = 4;
  $backStep = 2;
  $indent = $depth * $step - $backStep;
	return str_repeat('.', $indent);
	
}

function makeFullIndent($depth = 1)
{
	$step = 4;
  $indent = $depth * $step;
	return str_repeat('.', $indent);
	
}

function stringifyIter($data, $depth = 1) 
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
  			$output[] = makeFullIndent($depth + 1) . stringifyIter($key) . ": {" . PHP_EOL . stringifyIter($value, $depth + 2) . 
        PHP_EOL . makeFullIndent($depth + 1) . "}";// закрываем текщий уровень скобкой
  			}
  		if(!is_array($value)) {//если значение не массив, то просто формируем строку
  			$output[] = makeFullIndent($depth + 1) . stringifyIter($key) . ": " . stringifyIter($value);
  		}	
    } 
    
    $result = implode("\n", $output);
    return $result;
  }

  $failure = getType($data);
  Throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}

function stringify($data, $depth = 1)
{
	if(is_array($data)) {
		return "{\n" . stringifyIter($data) . PHP_EOL . makeFullIndent($depth) . "}";
	}
	
	return stringifyIter($data);
}


function formatStylish($diff, $depth = 1)
{
            $result = array_map(function($item) use ($depth) {

                $status = $item['status'];
                $key = stringify($item['key']);
                $smallIndent = makeSmallIndent($depth);
                $fullIndent = makeFullIndent($depth);

                switch ($status) {

                case 'added':
                    return $smallIndent . "+ " . $key . ": " . stringify($item['value'], $depth);
                    
                case 'removed':
                    return $smallIndent . "- " . $key . ": " . stringify($item['value'], $depth);

                case 'unchanged':
                  return $fullIndent . $key . ": " . stringify($item['value'], $depth);

                case 'updated':
                  return $smallIndent . "- " . $key . ": " . stringify($item['value1'], $depth) . PHP_EOL 
                  . $smallIndent . "+ " . $key . ": " . stringify($item['value2'], $depth);

                case 'have children':
                    return $fullIndent . $key . ": {" . PHP_EOL . formatStylish($item['value'], $depth + 1) . PHP_EOL 
                    . $fullIndent . "}";
                  
                default:
                    throw new \Exception('Unknown status');   
                }
              }, $diff);
          return implode("\n", $result);

          }

function makeStylish($diff)
{
  $result = formatStylish($diff);
  return "{\n{$result}\n}";
}

     
    

