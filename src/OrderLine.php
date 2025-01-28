<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'order_lines')]
class OrderLine{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'order_lines')]
    private Order|null $order = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    private Product|null $product = null;

    #[ORM\Column(type:"decimal", precision:2, scale:15)]
    private string|null $Quantity = null;

}