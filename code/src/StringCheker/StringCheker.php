<?php

declare(strict_types=1);

namespace Otus\Balancer\StringCheker;

class StringCheker
{
  public function check(?string $str = null)
  {
    $response = new Response();
    if (!$str) {
      $response->error("string is <b>NOT PASSED</b>");
      return;
    }
    $isValid = (new BracketsValidator())->validate($str);
    if ($isValid) {
      $response->success();
    } else {
      $response->error();
    }
  }
}
