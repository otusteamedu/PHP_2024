<?php

class DIContainer {
    protected $instances = [];

 
    public function set(string $name, $instance) {
        $this->instances[$name] = $instance;
    }

 
    public function get(string $name) {
        if (isset($this->instances[$name])) {
            return $this->instances[$name];
        }
        throw new Exception("Экземпляр с именем '$name' не зарегистрирован в контейнере.");
    }

    /**
     * Регистрирует фабрику продукта, используя DI.
     */
    public function registerProductFactory(string $type) {
        switch ($type) {
            case 'burger':
                $this->set('productFactory', new BurgerFactory());
                break;
            case 'sandwich':
                $this->set('productFactory', new SandwichFactory());
                break;
            case 'hotdog':
                $this->set('productFactory', new HotdogFactory());
                break;
            default:
                throw new Exception("Неизвестный тип фабрики: $type");
        }
    }
}

// Пример использования DIContainer
$container = new DIContainer();
$container->registerProductFactory('burger');

// Получаем фабрику и создаем продукт
$productFactory = $container->get('productFactory');
$product = $productFactory->createProduct();
