<?php
declare(strict_types=1);

namespace App\Application\UseCase\Cooking;

use App\Application\Interface\Observer\PublisherInterface;
use App\Domain\Entity\Product;

class CookingUseCase
{

    private $product;
    private $publisher;

    public function __construct(
        PublisherInterface $publisher
    ){}

    public function __invoke()
    {
        $this->product->setStatus(2);
        $this->publisher->notify($this->product->getStatus());
    }

}