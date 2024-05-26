<?php
declare(strict_types=1);

namespace App\Domain\Entity;


use App\Domain\ValueObject\;

class News
{
    public  $url;
    public string $title;


    public function __construct(
        ValueObjectUrl $url,
        string $title
    )
    {}

}