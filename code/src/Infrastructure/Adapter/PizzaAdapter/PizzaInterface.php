<?php
declare(strict_types=1);

namespace App\Infrastructure\Adapter\PizzaAdapter;

interface PizzaInterface
{
    public function getSpecialDough(): string;
    public function getPizza(): string;

}