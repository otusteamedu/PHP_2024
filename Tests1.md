Покажу примеры unit тестов для разных слоев приложения. Сначала нужно добавить PHPUnit в проект:

```json
// composer.json
{
    "require-dev": {
        "phpunit/phpunit": "^10.0",
        "mockery/mockery": "^1.6"
    }
}
```

### 1. Тесты доменного слоя

```php
// tests/Domain/Entity/NewsTest.php
namespace Tests\Domain\Entity;

use PHPUnit\Framework\TestCase;
use Anatolyshilyaev\Hw14\Domain\Entity\News;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Title;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Date;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;

class NewsTest extends TestCase
{
    public function testCreateNews(): void
    {
        $title = new Title('Test Title');
        $date = new Date(new \DateTimeImmutable());
        $url = new Url('https://example.com');

        $news = new News($title, $date, $url);

        $this->assertEquals($title, $news->getTitle());
        $this->assertEquals($date, $news->getDate());
        $this->assertEquals($url, $news->getUrl());
    }
}

// tests/Domain/ValueObject/TitleTest.php
class TitleTest extends TestCase
{
    public function testValidTitle(): void
    {
        $title = new Title('Valid Title');
        $this->assertEquals('Valid Title', $title->getValue());
    }

    public function testTooLongTitle(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Title(str_repeat('a', 256));
    }
}

// tests/Domain/ValueObject/UrlTest.php
class UrlTest extends TestCase
{
    public function testValidUrl(): void
    {
        $url = new Url('https://example.com');
        $this->assertEquals('https://example.com', $url->getValue());
    }

    public function testInvalidUrl(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new Url('not-a-url');
    }
}
```

### 2. Тесты слоя приложения (Use Cases)

```php
// tests/Application/UseCase/CreateNews/CreateNewsUseCaseTest.php
namespace Tests\Application\UseCase;

use PHPUnit\Framework\TestCase;
use Mockery;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Domain\Factory\NewsFactoryInterface;
use Anatolyshilyaev\Hw14\Domain\Repository\NewsRepositoryInterface;
use Anatolyshilyaev\Hw14\Application\NewsParser\NewsParserInterface;

class CreateNewsUseCaseTest extends TestCase
{
    private $newsFactory;
    private $newsParser;
    private $newsRepository;
    private $useCase;

    protected function setUp(): void
    {
        $this->newsFactory = Mockery::mock(NewsFactoryInterface::class);
        $this->newsParser = Mockery::mock(NewsParserInterface::class);
        $this->newsRepository = Mockery::mock(NewsRepositoryInterface::class);

        $this->useCase = new CreateNewsUseCase(
            $this->newsFactory,
            $this->newsParser,
            $this->newsRepository
        );
    }

    public function testCreateNews(): void
    {
        $url = 'https://example.com';
        $title = 'Test Title';
        $request = new CreateNewsRequest($url);

        // Настраиваем ожидаемое поведение моков
        $this->newsParser->shouldReceive('parse')
            ->once()
            ->andReturn($title);

        $news = Mockery::mock(News::class);
        $news->shouldReceive('getId')->andReturn(1);

        $this->newsFactory->shouldReceive('create')
            ->once()
            ->andReturn($news);

        $this->newsRepository->shouldReceive('save')
            ->once()
            ->with($news);

        $response = ($this->useCase)($request);

        $this->assertEquals(1, $response->id);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
```

### 3. Тесты инфраструктурного слоя

```php
// tests/Infrastructure/NewsParser/NewsParserTest.php
namespace Tests\Infrastructure\NewsParser;

use PHPUnit\Framework\TestCase;
use Anatolyshilyaev\Hw14\Infrastructure\NewsParser\NewsParser;
use Anatolyshilyaev\Hw14\Domain\ValueObject\Url;

class NewsParserTest extends TestCase
{
    private NewsParser $parser;

    protected function setUp(): void
    {
        $this->parser = new NewsParser();
    }

    public function testParse(): void
    {
        // Создаем временный HTML файл для теста
        $html = '<html><head><title>Test Title</title></head><body></body></html>';
        $tempFile = tempnam(sys_get_temp_dir(), 'test');
        file_put_contents($tempFile, $html);

        $url = new Url('file://' . $tempFile);
        $result = $this->parser->parse($url);

        $this->assertEquals('Test Title', $result);

        unlink($tempFile);
    }
}

// tests/Infrastructure/ReportGenerator/ReportGeneratorTest.php
class ReportGeneratorTest extends TestCase
{
    private ReportGenerator $generator;

    protected function setUp(): void
    {
        $this->generator = new ReportGenerator();
    }

    public function testGenerate(): void
    {
        $news = [
            [
                'title' => 'Test Title',
                'url' => 'https://example.com'
            ]
        ];

        $filename = $this->generator->generate($news);

        $this->assertFileExists($filename);
        $content = file_get_contents($filename);
        $this->assertStringContainsString('Test Title', $content);
        $this->assertStringContainsString('https://example.com', $content);

        unlink($filename);
    }
}
```

### 4. Тесты контроллеров

```php
// tests/Infrastructure/Http/CreateNewsControllerTest.php
namespace Tests\Infrastructure\Http;

use PHPUnit\Framework\TestCase;
use Mockery;
use Anatolyshilyaev\Hw14\Infrastructure\Http\CreateNewsController;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsUseCase;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsRequest;
use Anatolyshilyaev\Hw14\Application\UseCase\CreateNews\CreateNewsResponse;

class CreateNewsControllerTest extends TestCase
{
    private $useCase;
    private $controller;

    protected function setUp(): void
    {
        $this->useCase = Mockery::mock(CreateNewsUseCase::class);
        $this->controller = new CreateNewsController($this->useCase);
    }

    public function testCreate(): void
    {
        $request = new CreateNewsRequest('https://example.com');
        $response = new CreateNewsResponse(1);

        $this->useCase->shouldReceive('__invoke')
            ->once()
            ->with(Mockery::type(CreateNewsRequest::class))
            ->andReturn($response);

        $result = $this->controller->create($request);

        $this->assertEquals($response, $result);
    }

    protected function tearDown(): void
    {
        Mockery::close();
    }
}
```

### 5. Настройка PHPUnit

```xml
<!-- phpunit.xml -->
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
         xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         bootstrap="vendor/autoload.php"
         colors="true">
    <testsuites>
        <testsuite name="Unit">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
    <coverage>
        <include>
            <directory suffix=".php">src</directory>
        </include>
    </coverage>
</phpunit>
```

### Рекомендации по тестированию:

1. **Структура тестов**:
- Следуйте структуре исходного кода
- Один тестовый класс на один класс приложения
- Понятные названия тестовых методов

2. **Изоляция тестов**:
- Используйте моки для внешних зависимостей
- Сбрасывайте состояние после каждого теста
- Избегайте зависимостей между тестами

3. **Покрытие кода**:
- Стремитесь к высокому покрытию доменного слоя
- Тестируйте граничные случаи
- Проверяйте обработку ошибок

4. **Continuous Integration**:
```yaml
# .github/workflows/tests.yml
name: Tests
on: [push, pull_request]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - name: Install dependencies
        run: composer install
      - name: Run tests
        run: vendor/bin/phpunit
```

Это базовое покрытие тестами. По мере развития проекта можно добавлять больше тестов и сценариев тестирования.