<?php

function makeIndent($symbol, $depth)
{
	$indent = $depth * 4 - 2; //формула для расчета отступа
	return str_repeat($symbol, $indent);
}


function stringify($data, $symbol = '. ', $depth = 1) 
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
  			$output[] = makeIndent($symbol, $depth) . stringify($key) . ": {" . PHP_EOL . stringify($value, $symbol, $depth + 1);
  			
  			$output[] = makeIndent($symbol, $depth) . "}";// закрываем текщий уровень скобкой
  			}
  		if(!is_array($value)) {//если значение не массив, то просто формируем строку
  			$output[] = makeIndent($symbol, $depth) . stringify($key) . ": " . stringify($value);
  		}	
    } 
    
    $result = implode("\n", $output);//строка???
    //return $result;
    //return '{' . PHP_EOL . $result . PHP_EOL . '}';
  } 
}


$data = ['hello' => 'world', 'is' => true, 'nested' => ['count' => 5]];

print_r(stringify($data));