<?php

namespace KRudenko\Otus\Command;

use Exception;
use KRudenko\Otus\Service\SpiderService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:spider', 'Сбор данных о книгах с labirint.ru')]
class SpiderCommand extends Command
{
    protected function configure(): void
    {
        $this
            ->addArgument('path', InputArgument::OPTIONAL, 'Путь до каталога на сайте labirint.ru', 'https://www.labirint.ru/books/')
            ->setHelp('Автоматический парсинг книг с использованием безопасных интервалов');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('🕷️ Запуск парсинга...');

        try {
            $path = $input->getArgument('path');
            (new SpiderService())->run($output, $path);

            $output->writeln('✅ Данные успешно сохранены');

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('<error>❌ Ошибка: ' . $e->getMessage() . '</error>');

            return Command::FAILURE;
        }
    }
}
