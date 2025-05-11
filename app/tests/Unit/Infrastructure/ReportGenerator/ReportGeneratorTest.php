<?php

namespace Anatolyshilyaev\Hw14\Tests\Infrastructure\ReportGenerator;

use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorRequest;
use Anatolyshilyaev\Hw14\Application\ReportGenerator\ReportGeneratorResponse;
use Anatolyshilyaev\Hw14\Infrastructure\ReportGenerator\ReportGenerator;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ReportGeneratorTest extends TestCase
{
    private ReportGenerator $generator;
    private string $defaultFolder = 'saved_reports';

    protected function setUp(): void
    {
        $this->generator = new ReportGenerator();

        // Очищаем папку перед тестами
        if (is_dir($this->defaultFolder)) {
            array_map('unlink', glob($this->defaultFolder . '/*'));
            @rmdir($this->defaultFolder);
        }
    }

    protected function tearDown(): void
    {
        // Удаляем созданные файлы после тестов
        if (is_dir($this->defaultFolder)) {
            array_map('unlink', glob($this->defaultFolder . '/*'));
            @rmdir($this->defaultFolder);
        }
    }

    public function testGenerateCreatesFolderIfNotExists(): void
    {
        // Arrange
        $requests = [new ReportGeneratorRequest('Test', 'https://test.com')];

        // Убедимся, что папки нет
        if (is_dir($this->defaultFolder)) {
            rmdir($this->defaultFolder);
        }
        $this->assertDirectoryDoesNotExist($this->defaultFolder);

        // Act
        $response = $this->generator->generate($requests);

        // Assert
        $this->assertDirectoryExists($this->defaultFolder);
    }

    public function testGenerateReturnsCorrectFilenameFormat(): void
    {
        // Arrange
        $requests = [new ReportGeneratorRequest('Test', 'https://test.com')];

        // Act
        $response = $this->generator->generate($requests);

        // Assert
        $this->assertMatchesRegularExpression(
            '#^saved_reports/report_[0-9a-f]{8}-[0-9a-f]{4}-4[0-9a-f]{3}-[89ab][0-9a-f]{3}-[0-9a-f]{12}\.html$#',
            $response->filename
        );
    }

    public function testGenerateHandlesEmptyRequest(): void
    {
        // Act
        $response = $this->generator->generate([]);

        // Assert
        $this->assertInstanceOf(ReportGeneratorResponse::class, $response);
        $this->assertFileExists($response->filename);

        $content = file_get_contents($response->filename);
        $this->assertStringContainsString('<ul></ul>', $content);
    }

    public function testGenerateCreatesValidUuid(): void
    {
        // Arrange
        $requests = [new ReportGeneratorRequest('Test', 'https://test.com')];

        // Act
        $response = $this->generator->generate($requests);

        // Extract UUID from filename
        preg_match('/report_([^\.]+)\.html/', $response->filename, $matches);
        $uuid = $matches[1];

        // Assert
        $this->assertTrue(Uuid::isValid($uuid));
    }
}
