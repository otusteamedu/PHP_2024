<?php

declare(strict_types=1);

namespace App\Blog\Console\Command;

use App\Blog\DataMapper\PostMapper;
use App\Shared\Utility\ListFormatter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindBlogPostByIdCommand extends Command
{
    private const ARGUMENT_POST_ID = 'post_id';

    public function __construct(
        private readonly PostMapper $postMapper,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('blog:posts:find-by-id')
            ->setDescription('Find blog post by ID')
            ->addArgument(
                self::ARGUMENT_POST_ID,
                InputArgument::REQUIRED,
                'Blog post id'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $postId = $input->getArgument(self::ARGUMENT_POST_ID);

        $post = $this->postMapper->findById((int) $postId);

        if (null === $post) {
            $output->writeln('<error>Blog post with provided ID does not exists</error>');

            return self::INVALID;
        }

        $table = ListFormatter::toTable([$post->toArray()]);

        (new Table($output))
            ->setHeaders($table['headers'])
            ->setRows($table['rows'])
            ->render()
        ;

        return self::SUCCESS;
    }
}
