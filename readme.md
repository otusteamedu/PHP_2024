# Домашняя работа анализ кода
## Код для анализа:
```php
<?php
class Router {
    private $routes;
    public function __construct() {
        // Путь к роутерам.
        $routesPath =  './core/config/routes.php';
        $this->routes = include($routesPath);
    }
    private function getURI() {
        // Получаем строку запроса
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }
    public function run() {
        //Получаем строку запроса
       $uri = $this->getURI();
      //Проверить наличие такого запроса в роутах
       foreach ($this->routes as $uriPattern => $path) {
            // Сравниваем $uriPattern и $uri
           if (preg_match("~^$uriPattern$~", $uri)) {
            //Получаем внутренний путь из внешнего солгасно правилу
            $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
            // Делим строку на две части
            $segments = explode('/', $internalRoute);
            //Получаем имя контроллера удаляя первый сегмент из $segments
            $controllerName = array_shift($segments).'Controller';
            $controllerName = ucfirst($controllerName);
            $actionName = 'action'.ucfirst(array_shift($segments));
            $parameters = $segments;
            //Подключаем файл контроллера
            $controllerFile = './core/controllers/' . $controllerName . '.php';
            if (file_exists($controllerFile)) {
                include_once($controllerFile);
            }
            $controllerObject = new $controllerName;
            $result = call_user_func_array(array($controllerObject, $actionName),$parameters);
            if ($result != null) {
               break;
            }
        }
       }
    }
}
```

## DRY (Don't Repeat Yourself)
Код не содержит явных повторений логики.

## KISS (Keep It Simple, Stupid)
Код относительно прост, но логика маршрутизации и обработки строк (preg_match, preg_replace, explode) смешана в одном методе run(). Это усложняет чтение и поддержку. Метод run() делает слишком много: парсинг URI, сопоставление маршрутов, загрузка контроллеров и вызов методов. Это нарушает принцип простоты.

## SOLID
- S (Single Responsibility Principle): Метод run() нарушает этот принцип, так как отвечает за парсинг URI, маршрутизацию, загрузку файлов и вызов методов.
- O (Open/Closed Principle): Код закрыт для расширения. Например, чтобы добавить поддержку middleware или кэширования маршрутов, придется переписывать run().
- L (Liskov Substitution Principle): Не применимо напрямую, так как нет наследования.
- I (Interface Segregation Principle): Отсутствуют интерфейсы, что затрудняет тестирование и замену компонентов.
- D (Dependency Inversion Principle): Зависимости (пути к файлам, создание контроллеров) жестко закодированы.

## YAGNI (You Aren't Gonna Need It)
Оценка: Код минималистичен, но отсутствие обработки ошибок и гибкости может привести к тому, что в будущем придется добавлять больше функционала, чем нужно сейчас.

## Design Patterns (Банда Четырёх)
Оценка: Код не использует явных шаблонов проектирования.

## Переделка:
```php
<?php
class Router {
    private array $routes;
    private string $routesPath;
    private string $controllersPath;

    public function __construct(string $routesPath = './core/config/routes.php', string $controllersPath = './core/controllers/') {
        $this->routesPath = $routesPath;
        $this->controllersPath = $controllersPath;
        $this->loadRoutes();
    }
    private function loadRoutes(): void {
        if (!file_exists($this->routesPath)) {
            throw new \RuntimeException("Routes file not found: {$this->routesPath}");
        }
        $this->routes = include $this->routesPath;
    }
    private function getUri(): ?string {
        return !empty($_SERVER['REQUEST_URI']) ? trim($_SERVER['REQUEST_URI'], '/') : null;
    }
    public function run(): void {
        $uri = $this->getUri();
        if ($uri === null) {
            throw new \RuntimeException('Invalid request URI');
        }
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~^$uriPattern$~", $uri)) {
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/', $internalRoute);

                $controllerName = ucfirst(array_shift($segments)) . 'Controller';
                $actionName = 'action' . ucfirst(array_shift($segments));
                $parameters = $segments;
                $controllerFile = $this->controllersPath . $controllerName . '.php';
                if (!file_exists($controllerFile)) {
                    throw new \RuntimeException("Controller file not found: $controllerFile");
                }
                include_once $controllerFile;
                $controller = new $controllerName();
                if (!method_exists($controller, $actionName)) {
                    throw new \RuntimeException("Action $actionName not found in $controllerName");
                }

                call_user_func_array([$controller, $actionName], $parameters);
                return;
            }
        }
        throw new \RuntimeException("No route matched for URI: $uri");
    }
}
```
## Что изменено:
Пути к файлам вынесены в свойства класса и задаются через конструктор с значениями по умолчанию
Логика разделена на небольшие методы, каждый из которых выполняет одну простую задачу.

Добавлена базовая обработка ошибок через исключения.
Код стал более читаемым за счет выделения логики в отдельные методы.

- S: Класс Router теперь отвечает только за маршрутизацию и базовую загрузку файлов, что ближе к принципу единственной ответственности.
- O: Код по-прежнему не идеально открыт для расширения, но его проще модифицировать благодаря выделению методов.
- L, I: Не применимы напрямую, так как нет наследования или интерфейсов.
- D: Зависимости (пути) передаются через конструктор, что немного улучшает инверсию зависимостей, хотя include остается жесткой связью.
