<?php
$keyRequest = "string";
try {
  echo checkRequest($_POST, $keyRequest);
} catch (Exception $e) {
  echo $e->getMessage();
}
function checkRequest($request, $keyRequest)
{
  if (empty($request)) {
    header("HTTP/1.0 400 Bad Request");
    throw new Exception("Передан пустой массив");
  } else if (!array_key_exists($keyRequest, $request)) {
    header("HTTP/1.0 400 Bad Request");
    throw new Exception("Не указан параметр с ключом " . $keyRequest);
  } else if (!isCorrect($request[$keyRequest])) {
    header("HTTP/1.0 400 Bad Request");
    throw new Exception("Ошибка в скобках, проверьте правильность написания");
  } else {
    header("HTTP/1.0 200 OK");
    return "Ошибок не найдено";
  }
}

function isCorrect($string)
{
  $len = strlen($string);
  $stack = [];
  for ($i = 0; $i < $len; $i++) {
    $simbol = $string[$i];
    if ($simbol == '(') {
      $stack[] = $simbol;
    } elseif ($simbol == ')') {
      if (!$last = array_pop($stack)) {
        return false;
      } elseif ($simbol === ')' && $last != '(') {
        return false;
      }
    }
  }
  return count($stack) === 0;
}
