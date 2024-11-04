<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\News;
use App\Domain\Repository\NewsRepositoryInterface;
use App\Infrastructure\Helpers\LoadConfig;
use App\Domain\ValueObject\Url;
use App\Domain\ValueObject\Date;
use App\Domain\ValueObject\Title;
use Symfony\Component\HttpFoundation\Request;

class FileNewsRepository implements NewsRepositoryInterface
{
    private string $newsPath;

    public function __construct()
    {
        $config = LoadConfig::load();
        $this->newsPath = $config['newsPath'];
        if (!file_exists($this->newsPath)) {
            throw new \DomainException('No isset file path for news: ' . $this->newsPath);
        }
    }

    public function findByIds(iterable $ids): iterable
    {
        $result = [];

        $ids = array_filter($ids, 'strlen');

        if (!empty($ids)) {
            foreach ($ids as $id) {
                $data = $this->readFile($id);
                $this->validateFileData($data);
                $result[] = $this->createNews((int)$id, $data['date'], $data['url'], $data['title']);
            }
        }

        return $result;
    }

    public function save(News $news): void
    {
        $id = $this->getNextId();
        $data = ['date' => $news->getDate()->getValue()->format('Y-m-d H:i:s'), 'url' => $news->getUrl()->getValue(), 'title' => $news->getTitle()->getValue()];

        $this->saveInFile($id, json_encode($data, JSON_UNESCAPED_UNICODE));
        $this->setId($id, $news);
    }

    public function findAll(): iterable
    {
        $result = [];

        $arFileName = $this->getFileList();
        if (!empty($arFileName)) {
            foreach ($arFileName as $file) {
                $data = $this->readFile($file);
                $this->validateFileData($data);
                $arData[$data['id']] = $data;
            }
            arsort($arData);

            foreach ($arData as $oneData) {
                $result[] = $this->createNews($oneData['id'], $oneData['date'], $oneData['url'], $oneData['title']);
            }
        }

        return $result;
    }

    private function validateFileData(array $data): void
    {
        if (!isset($data['id']) || !isset($data['id']) || !isset($data['id']) || !isset($data['id'])) {
            throw new \DomainException('Error read file - no isset required fields');
        }
    }

    private function createNews(int $id, string $date, string $url, string $title)
    {
        $news = new News(
            new Date(new \DateTimeImmutable($date)),
            new Url($url),
            new Title($title)
        );
        $this->setId($id, $news);

        return $news;
    }

    private function setId(int $id, News $news): void
    {
        $reflectionProperty = new \ReflectionProperty(News::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($news, $id);
    }

    private function readFile($fileName): array
    {
        $filePath = $this->newsPath . $fileName;
        if (!file_exists($filePath)) {
            throw new \DomainException('No isset file_path: ' . $filePath);
        }

        $fileData = json_decode(file_get_contents($filePath), true);
        $fileData['id'] = $fileName;

        return $fileData;
    }

    private function getNextId(): int
    {
        $arFileName = $this->getFileList();

        if (!empty($arFileName)) {
            rsort($arFileName);
            return ++$arFileName[0];
        } else {
            return 1;
        }
    }

    private function getFileList(): array
    {
        $arFileName = [];
        $files = scandir($this->newsPath);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..' || $file == '.gitignore') {
                continue;
            }
            $arFileName[] = (int)$file;
        }

        return $arFileName;
    }

    private function saveInFile($id, $data): void
    {
        if (!file_put_contents($this->newsPath . $id, $data)) {
            throw new \DomainException('Error save file news');
        }
    }
}
