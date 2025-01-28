<?php

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity]
#[ORM\Table(name: 'orders')]
class Order
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    private string $number;
    #[ORM\Column(type: 'DateTime')]
    private DateTime $date;

    /** @var Collection<int, Order_line> */
    #[ORM\ManyToMany(targetEntity: Order_line::class)]
    private Collection $order_lines;

    /**
     * Get the value of name
     */ 
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setNumber(string $number)
    {
        $this->number = $number;
        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setDate(DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    public function addLineToOrder(Order_line $order_line): void
    {
        $this->order_lines[] = $order_line;
    }

    /** @return Collection<int, Product> */
    public function getProducts(): Collection
    {
        return $this->products;
    }
}

