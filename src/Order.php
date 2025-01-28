<?php
namespace Skudashkin\Hw16;
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
    #[ORM\Column(type: 'date')]
    private DateTime $date;

    /** @var Collection<int,Bug> An ArrayCollection of Bug objects. */
    #[ORM\OneToMany(targetEntity: OrderLine::class, mappedBy: 'order')]
    private $order_lines;

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
    public function setDate($date)
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

    public function addLineToOrder(Order_line $order_line)
    {
        $this->order_lines[] = $order_line;
        return $this;
    }

    /** @return Collection<int, Product> */
    public function getLines(): Collection
    {
        return $this->order_lines;
    }
}

