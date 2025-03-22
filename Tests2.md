# Стратегия покрытия системы юнит-тестами

Для эффективного покрытия медиа-мониторинговой системы юнит-тестами, следует придерживаться следующей стратегии:

## 1. Настройка тестового окружения

1. **Установка PHPUnit**:
   ```bash
   composer require --dev phpunit/phpunit
   ```

2. **Создание структуры директорий**:
   ```
   app/
   ├── src/
   └── tests/
       ├── Unit/
       │   ├── Domain/
       │   ├── Application/
       │   └── Infrastructure/
       └── Integration/
   ```

3. **Настройка phpunit.xml**:
   ```xml
   <phpunit bootstrap="vendor/autoload.php">
     <testsuites>
       <testsuite name="Unit">
         <directory>tests/Unit</directory>
       </testsuite>
       <testsuite name="Integration">
         <directory>tests/Integration</directory>
       </testsuite>
     </testsuites>
   </phpunit>
   ```

4. **Обновление composer.json**:
   ```json
   "autoload-dev": {
     "psr-4": {
       "Tests\\": "tests/"
     }
   }
   ```

## 2. Тестирование доменного слоя

### ValueObjects

Для каждого ValueObject (Title, Url, Date) создать тесты:

```php
// tests/Unit/Domain/ValueObject/TitleTest.php
namespace Tests\Unit\Domain\ValueObject;

use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use PHPUnit\Framework\TestCase;

class TitleTest extends TestCase
{
    public function testCreateValidTitle(): void
    {
        $title = new Title("Валидный заголовок");
        $this->assertEquals("Валидный заголовок", $title->getValue());
    }
    
    public function testTitleTooLong(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $longTitle = str_repeat("a", 256);
        new Title($longTitle);
    }
}
```

Аналогично для Url и Date.

### Entity

```php
// tests/Unit/Domain/Entity/NewsTest.php
namespace Tests\Unit\Domain\Entity;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewsTest extends TestCase
{
    public function testNewsCreation(): void
    {
        $title = new Title("Тестовый заголовок");
        $date = new Date(new DateTimeImmutable());
        $url = new Url("https://example.com");
        
        $news = new News($title, $date, $url);
        
        $this->assertSame($title, $news->getTitle());
        $this->assertSame($date, $news->getDate());
        $this->assertSame($url, $news->getUrl());
        $this->assertNull($news->getId());
    }
}
```

## 3. Тестирование слоя приложения (Use Cases)

Для тестирования Use Cases потребуются моки зависимостей:

```php
// tests/Unit/Application/UseCase/CreateNews/CreateNewsUseCaseTest.php
namespace Tests\Unit\Application\UseCase\CreateNews;

use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserInterface;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class CreateNewsUseCaseTest extends TestCase
{
    public function testInvoke(): void
    {
        // Arrange
        $url = "https://example.com";
        $title = "Тестовый заголовок";
        $newsId = 1;
        
        // Мок NewsParser
        $newsParser = $this->createMock(NewsParserInterface::class);
        $newsParser->expects($this->once())
                  ->method('parse')
                  ->willReturn($title);
        
        // Мок News
        $news = $this->createMock(News::class);
        $news->method('getId')
             ->willReturn($newsId);
        
        // Мок NewsFactory
        $newsFactory = $this->createMock(NewsFactoryInterface::class);
        $newsFactory->expects($this->once())
                   ->method('create')
                   ->willReturn($news);
        
        // Мок NewsRepository
        $newsRepository = $this->createMock(NewsRepositoryInterface::class);
        $newsRepository->expects($this->once())
                      ->method('save');
        
        // Act
        $useCase = new CreateNewsUseCase($newsFactory, $newsParser, $newsRepository);
        $request = new CreateNewsRequest($url);
        $response = $useCase($request);
        
        // Assert
        $this->assertEquals($newsId, $response->id);
    }
}
```

Аналогично для других Use Cases.

## 4. Тестирование инфраструктурного слоя

### Factory

```php
// tests/Unit/Infrastructure/Factory/NewsFactoryTest.php
namespace Tests\Unit\Infrastructure\Factory;

use Anatolyshilyaev\Hw14\Infrastructure\Factory\NewsFactory;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewsFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $title = new Title("Тестовый заголовок");
        $date = new Date(new DateTimeImmutable());
        $url = new Url("https://example.com");
        
        $factory = new NewsFactory();
        $news = $factory->create($title, $date, $url);
        
        $this->assertSame($title, $news->getTitle());
        $this->assertSame($date, $news->getDate());
        $this->assertSame($url, $news->getUrl());
    }
}
```

### NewsParser

```php
// tests/Unit/Infrastructure/NewsParser/NewsParserTest.php
namespace Tests\Unit\Infrastructure\NewsParser;

use Anatolyshilyaev\Hw14\Infrastructure\NewsParser\NewsParser;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use PHPUnit\Framework\TestCase;

class NewsParserTest extends TestCase
{
    public function testParse(): void
    {
        // Для этого теста потребуется мокирование file_get_contents
        // или использование библиотеки php-mock
        
        // Альтернативный подход - создание тестового HTML-файла
        $testHtml = '<html><head><title>Тестовый заголовок</title></head><body></body></html>';
        file_put_contents('test.html', $testHtml);
        
        $parser = new NewsParser();
        $url = $this->createMock(Url::class);
        $url->method('getValue')
            ->willReturn('file://' . realpath('test.html'));
        
        $result = $parser->parse($url);
        
        $this->assertEquals('Тестовый заголовок', $result);
        
        unlink('test.html');
    }
}
```

### ReportGenerator

```php
// tests/Unit/Infrastructure/ReportGenerator/ReportGeneratorTest.php
namespace Tests\Unit\Infrastructure\ReportGenerator;

use Anatolyshilyaev\Hw14\Infrastructure\ReportGenerator\ReportGenerator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ReportGeneratorTest extends TestCase
{
    public function testGenerate(): void
    {
        // Мокируем Uuid для предсказуемого имени файла
        $uuid = '12345678-1234-1234-1234-123456789012';
        $uuidMock = $this->createMock(Uuid::class);
        $uuidMock->method('toString')
                ->willReturn($uuid);
        
        // Подготавливаем тестовые данные
        $news = [
            [
                'title' => 'Тестовый заголовок 1',
                'url' => 'https://example.com/1'
            ],
            [
                'title' => 'Тестовый заголовок 2',
                'url' => 'https://example.com/2'
            ]
        ];
        
        $generator = new ReportGenerator();
        $filename = $generator->generate($news);
        
        $this->assertFileExists($filename);
        $content = file_get_contents($filename);
        
        $this->assertStringContainsString('Тестовый заголовок 1', $content);
        $this->assertStringContainsString('Тестовый заголовок 2', $content);
        $this->assertStringContainsString('https://example.com/1', $content);
        $this->assertStringContainsString('https://example.com/2', $content);
        
        // Очистка
        unlink($filename);
    }
}
```

### Controllers

```php
// tests/Unit/Infrastructure/Http/CreateNewsControllerTest.php
namespace Tests\Unit\Infrastructure\Http;

use Anatolyshilyaev\Hw14\Infrastructure\Http\CreateNewsController;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;
use PHPUnit\Framework\TestCase;

class CreateNewsControllerTest extends TestCase
{
    public function testCreate(): void
    {
        // Arrange
        $request = new CreateNewsRequest('https://example.com');
        $response = new CreateNewsResponse(1);
        
        $useCase = $this->createMock(CreateNewsUseCase::class);
        $useCase->expects($this->once())
               ->method('__invoke')
               ->with($this->equalTo($request))
               ->willReturn($response);
        
        $controller = new CreateNewsController($useCase);
        
        // Act
        $result = $controller->create($request);
        
        // Assert
        $this->assertSame($response, $result);
    }
    
    public function testCreateWithException(): void
    {
        // Arrange
        $request = new CreateNewsRequest('https://example.com');
        $exceptionMessage = 'Test exception';
        
        $useCase = $this->createMock(CreateNewsUseCase::class);
        $useCase->expects($this->once())
               ->method('__invoke')
               ->willThrowException(new \Exception($exceptionMessage));
        
        $controller = new CreateNewsController($useCase);
        
        // Act
        $result = $controller->create($request);
        
        // Assert
        $this->assertSame($exceptionMessage, $result);
    }
}
```

## 5. Интеграционные тесты для Repository

Для тестирования репозитория потребуется тестовая БД:

```php
// tests/Integration/Infrastructure/Repository/NewsRepositoryTest.php
namespace Tests\Integration\Infrastructure\Repository;

use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;
use Anatolyshilyaev\Hw14\Infrastructure\Repository\NewsRepository;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

class NewsRepositoryTest extends TestCase
{
    private $pdo;
    private $repository;
    
    protected function setUp(): void
    {
        // Настройка тестовой БД
        $this->pdo = new \PDO('sqlite::memory:');
        $this->pdo->exec('
            CREATE TABLE news (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                title VARCHAR(255) NOT NULL,
                date DATE NOT NULL,
                url TEXT NOT NULL
            )
        ');
        
        // Здесь нужно модифицировать NewsRepository для поддержки внедрения PDO
        $this->repository = new NewsRepository($this->pdo);
    }
    
    public function testSaveAndFindAll(): void
    {
        // Создаем новость
        $title = new Title("Тестовый заголовок");
        $date = new Date(new DateTimeImmutable());
        $url = new Url("https://example.com");
        $news = new News($title, $date, $url);
        
        // Сохраняем новость
        $this->repository->save($news);
        
        // Проверяем, что ID присвоен
        $this->assertNotNull($news->getId());
        
        // Получаем все новости
        $allNews = $this->repository->findAll();
        $this->assertCount(1, $allNews);
        
        $firstNews = $allNews[0];
        $this->assertEquals($news->getId(), $firstNews['id']);
        $this->assertEquals($title->getValue(), $firstNews['title']);
        $this->assertEquals($date->getValue()->format('Y-m-d'), $firstNews['date']);
        $this->assertEquals($url->getValue(), $firstNews['url']);
    }
}
```

## 6. Тестирование Router

```php
// tests/Unit/RouterTest.php
namespace Tests\Unit;

use Anatolyshilyaev\Hw14\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    public function testAdd(): void
    {
        $router = new Router();
        $called = false;
        
        $router->add('/test', function() use (&$called)