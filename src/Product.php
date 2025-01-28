<?php

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'products')]
class Product{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    private string|null $name = null;

    //#[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'order_lines')]
    //private Order|null $order = null;

}