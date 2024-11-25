<?php

function makeIndent($depth = 1)
{
	$indent = $depth * 4 - 2; //формула для расчета отступа
	return str_repeat('. ', $indent);
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
  			$output[] = makeIndent($depth) . stringify($key) . ": " . stringify($value);
  		}	
    } 
    
    $result = implode("\n", $output);
    return $result;
  }

  $failure = getType($data);
  Throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}

$data = ['one' => ['go1' => ['go2' => ['go3' => 15]], 'two' => 23]];
print_r(stringify($data));
