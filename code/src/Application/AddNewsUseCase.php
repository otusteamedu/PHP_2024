<?php
declare(strict_types=1);

namespace App\Application;




use App\Domain\NewsEntity;
use App\Domain\ValueObjectUrl;

class AddNewsUseCase
{
    public function addNews(ValueObjectUrl $url, string $title)
    {
        $news = new NewsEntity($url, $title);
        $interface = $this->addNews()
    }

}