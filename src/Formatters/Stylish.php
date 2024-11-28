<?php

namespace Differ\Formatters\Stylish;

function makeSmallIndent($depth)// неполный отступ, если перед ключом есть какой-то знак "+" или "-"
{
	$step = 4;
  $backStep = 2;
  $indent = $depth * $step - $backStep;
	return str_repeat('.', $indent);
	
}

function makeFullIndent($depth)//полный отступ, если пред ключом знака нет
{
	$step = 4;
  $indent = $depth * $step;
	return str_repeat('.', $indent);
	
}

function stringify($data) 
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
      $output[] = stringify($key) . ": " . stringify($value);
      }	
    
    $result = implode("\n", $output);
    return $result;
  }

  $failure = getType($data);
  Throw new \Exception(sprintf('Unknown format %s is given!', $failure));
}

function formatStylish($diff)
{
  $status = $diff['status'];
  
  switch ($status) {

    case 'root':
      $result = array_map(function($node) {
          $key = stringify($node['key']);
                    
          return formatStylish($node);
      }, $diff['children']);
      
      return implode("\n", $result);

    case 'added':
      return "+ " . $key . ": " . stringify($node['value']);

    case 'removed':
      return "- " . $key . ": " . stringify($node['value']);

    case 'unchanged':
      return "  " . $key . ": " . stringify($node['value']);

    case 'updated':
      return "- " . $key . ": " . stringify($node['value1']) . PHP_EOL 
                  . "+ " . $key . ": " . stringify($item['value2']);

    case 'have children':
      
      return array_map(function($child) {
        $key = stringify($child['key']);
        return formatStylish($child['children']);
      }, $node['children']);
                  
    default:
      throw new \Exception('Unknown status');
  }
               
}

function makeStylish($diff)
{
  $result = formatStylish($diff);
  return "{\n{$result}\n}";
}

     
    

