<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Adapter\PizzaAdapter;
use App\Adapter\PizzaSystem;
use App\Decorator\CheeseDecorator;
use App\Decorator\LettuceDecorator;
use App\Decorator\OnionDecorator;
use App\DI\Container;
use App\Factory\BurgerProcessorCreator;
use App\Observer\EmailNotifier;
use App\Observer\Order;
use App\Observer\SMSNotifier;
use App\Strategy\BurgerStrategy;
use App\Strategy\FoodContext;

// Create container
$container = new Container();

// Register services
$container->set(PizzaSystem::class, fn() => new PizzaSystem());
$container->set(BurgerStrategy::class, fn() => new BurgerStrategy());
$container->set(BurgerProcessorCreator::class, fn() => new BurgerProcessorCreator());
$container->set(EmailNotifier::class, fn() => new EmailNotifier());
$container->set(SMSNotifier::class, fn() => new SMSNotifier());

// Create order with DI
$strategy = $container->get(BurgerStrategy::class);
$foodContext = new FoodContext($strategy);
$burger = $foodContext->createFood();

// Add decorators
$burgerWithCheese = new CheeseDecorator($burger);
$burgerDeluxe = new LettuceDecorator($burgerWithCheese);
$burgerDeluxe = new OnionDecorator($burgerDeluxe);

// Process with factory
$processorCreator = $container->get(BurgerProcessorCreator::class);
$processor = $processorCreator->createFoodProcessor();
$finalBurger = $processor->process($burgerDeluxe);

// Create and process order with observers
$order = new Order(12345, $finalBurger);
$order->attach($container->get(EmailNotifier::class));
$order->attach($container->get(SMSNotifier::class));
$order->processOrder();

// Use adapter to make pizza
$pizzaSystem = $container->get(PizzaSystem::class);
$pizzaAdapter = new PizzaAdapter($pizzaSystem, "Pepperoni", ["cheese", "pepperoni", "mushrooms"]);

$pizzaOrder = new Order(12346, $pizzaAdapter);
$pizzaOrder->attach($container->get(EmailNotifier::class));
$pizzaOrder->processOrder();

echo "\nOrder Summary:\n";
echo $finalBurger->getDescription() . " - $" . $finalBurger->getPrice() . "\n";
echo $pizzaAdapter->getDescription() . " - $" . $pizzaAdapter->getPrice() . "\n";
