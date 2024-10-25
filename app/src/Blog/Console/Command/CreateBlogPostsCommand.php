<?php

declare(strict_types=1);

namespace App\Blog\Console\Command;

use App\Blog\DataMapper\PostMapper;
use App\Blog\Model\Post;
use App\Blog\Model\PostComment;
use App\Shared\Model\Collection;
use App\Shared\Utility\ListFormatter;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateBlogPostsCommand extends Command
{
    private const ARGUMENT_POST_TITLE = 'post_title';
    private const ARGUMENT_POST_CONTENT = 'post_content';
    private const ARGUMENT_POST_STATUS = 'post_status';
    private const ARGUMENT_POST_COMMENTS = 'post_comments';

    public function __construct(
        private readonly PostMapper $postMapper,
        ?string $name = null
    ) {
        parent::__construct($name);
    }

    protected function configure(): void
    {
        $this
            ->setName('blog:posts:create')
            ->setDescription('Creates new blog post')
            ->addArgument(
                self::ARGUMENT_POST_TITLE,
                InputArgument::REQUIRED
            )
            ->addArgument(
                self::ARGUMENT_POST_CONTENT,
                InputArgument::REQUIRED
            )
            ->addArgument(
                self::ARGUMENT_POST_STATUS,
                InputArgument::REQUIRED
            )
            ->addArgument(
                self::ARGUMENT_POST_COMMENTS,
                InputArgument::OPTIONAL
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $data = [
            'title' => $input->getArgument(self::ARGUMENT_POST_TITLE),
            'content' => $input->getArgument(self::ARGUMENT_POST_CONTENT),
            'status' => $input->getArgument(self::ARGUMENT_POST_STATUS),
        ];

        $post = Post::fromArray($data);

        if ($comments = $input->getArgument(self::ARGUMENT_POST_COMMENTS)) {
            $comments = array_map(
                fn(string $data): PostComment => new PostComment(null, null, $data),
                explode(',', $comments)
            );

            $post->setComments(new Collection($comments));
        }

        try {
            $post = $this->postMapper->save($post);
        } catch (Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return self::FAILURE;
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
