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

class SearchBlogPostsCommand extends Command
{
    private const OPTION_POST_ID = 'post_id';

    public function __construct(
        private readonly PostMapper $postMapper,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('blog:posts:search')
            ->setDescription('Searches for blog posts')
            ->addOption(
                self::OPTION_POST_ID,
                null,
                InputOption::VALUE_OPTIONAL,
                'ID of the blog post'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $postId = $input->getOption(self::OPTION_POST_ID);

        $posts = $postId
            ? $this->postMapper->findById((int) $postId)
            : $this->postMapper->findAll()->all();

        if (empty($posts)) {
            $output->writeln('<error>Blog posts matching your request does not exists</error>');

            return self::INVALID;
        }

        $posts = is_array($posts)
            ? array_map(fn(Post $post): array => $post->toArray(), $posts)
            : [$posts->toArray()];

        $table = ListFormatter::toTable($posts);

        (new Table($output))
            ->setHeaders($table['headers'])
            ->setRows($table['rows'])
            ->render()
        ;

        return self::SUCCESS;
    }
}
