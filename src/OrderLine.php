<?php
namespace Skudashkin\Hw16;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'order_lines')]
class OrderLine{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    function __construct(Order $order, Product $product, string $count){
        $this->order = $order;
        $this->product = $product;
        $this->count = $count;
    }

    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'order_lines')]
    private Order|null $order = null;

    #[ORM\ManyToOne(targetEntity: Product::class)]
    private Product|null $product = null;

    #[ORM\Column(type:"decimal", precision:15, scale:2)]
    private string|null $count = null;

    


    /**
     * Get the value of count
     */ 
    public function getCount()
    {
        return $this->count;
    }

    /**
     * Set the value of count
     *
     * @return  self
     */ 
    public function setCount($count)
    {
        $this->count = $count;

        return $this;
    }
}