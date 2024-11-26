<?php

function makeIndent($depth = 1)
{
	$indent = $depth * 4 - 2; //формула для расчета отступа
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
  			$output[] = makeIndent($depth) . stringifyIter($key) . ": {" . PHP_EOL . stringifyIter($value, $depth + 1);
  			
  			$output[] = makeIndent($depth) . "}";// закрываем текщий уровень скобкой
  			}
  		if(!is_array($value)) {//если значение не массив, то просто формируем строку
  			$output[] = makeIndent($depth) . stringifyIter($key) . ": " . stringifyIter($value);
  		}	
    } 
    
    $result = implode("\n", $output);
    return $result;
  }

  $failure = getType($data);
  Throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}

function stringify($data)
{
	if(is_array($data)) {
		return "{\n" . stringifyIter($data) . "\n}";
	}
	
	return stringifyIter($data);
}

$data = ['deep' => ['id' => ['number' => 45]], 'fee' => 100500];
print_r(stringify($data));
