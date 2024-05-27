<?php
declare(strict_types=1);

namespace App\Domain\Entity;


use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;

class News
{
    private int $id;


    public function __construct(
        private Url $url,
        private Title $title,
        private readonly Date $date
    )
    {}

    /**
     * @return mixed
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Url
     */
    public function getUrl(): Url
    {
        return $this->url;
    }

    /**
     * @return Title
     */
    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getDate(): Date
    {
        return $this->date;
    }

    /**
     * @param Url $url
     */
    public function setUrl(Url $url): void
    {
        $this->url = $url;
    }

    /**
     * @param Title $title
     */
    public function setTitle(Title $title): void
    {
        $this->title = $title;
    }

}