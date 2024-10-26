<?php

declare(strict_types=1);

namespace App\Blog\Console\Command;

use App\Blog\DataMapper\PostMapper;
use App\Blog\Model\Post;
use App\Shared\Utility\ListFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ListBlogPostsCommand extends Command
{
    private const OPTION_PAGE_NUMBER = 'page_number';
    private const OPTION_PAGE_SIZE = 'page_size';

    public function __construct(
        private readonly PostMapper $postMapper,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('blog:posts:list')
            ->setDescription('List blog posts')
            ->addOption(
                self::OPTION_PAGE_SIZE,
                null,
                InputOption::VALUE_OPTIONAL,
                'Count of blog posts per page',
                25
            )
            ->addOption(
                self::OPTION_PAGE_NUMBER,
                null,
                InputOption::VALUE_OPTIONAL,
                'Page number',
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $pageSize = (int) $input->getOption(self::OPTION_PAGE_SIZE);
        $pageNumber = $input->getOption(self::OPTION_PAGE_NUMBER);
        $pageNumber = (null === $pageNumber) ? 1 : (int) $pageNumber;

        $posts = $this->postMapper->findAll($pageSize, $pageNumber);
        $foundPostCount = $posts->count();

        if ($foundPostCount === 0) {
            $output->writeln('<error>Blog posts matching your request does not exists</error>');

            return self::INVALID;
        }

        $totalPostCount = $this->postMapper->count();

        $table = ListFormatter::toTable(array_map(fn(Post $post): array => $post->toArray(), $posts->all()));

        (new Table($output))
            ->setHeaders($table['headers'])
            ->setRows($table['rows'])
            ->render()
        ;

        $output->writeln(
            sprintf(
                '<info>Showing [%s] of total [%s], page [%s] of total [%s]</info>',
                $foundPostCount,
                $totalPostCount,
                $pageNumber,
                ceil($totalPostCount / $pageSize)
            )
        );

        return self::SUCCESS;
    }
}
