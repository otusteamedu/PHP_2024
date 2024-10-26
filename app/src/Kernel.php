<?php

declare(strict_types=1);

namespace App;

use App\Blog\Console\Command\FindBlogPostByIdCommand;
use App\Blog\Console\Command\ListBlogPostsCommand;
use App\Blog\DataMapper\PostCommentMapper;
use App\Blog\DataMapper\PostMapper;
use App\Shared\Console\Command\ExecuteDatabaseImportCommand;
use App\Shared\Database\PDOFactory;
use Symfony\Component\Console\Application;

final readonly class Kernel
{
    public function run(): void
    {
        $application = new Application();

        $pdo = (new PdoFactory())->make();

        $postCommentMapper = new PostCommentMapper($pdo);
        $postMapper = new PostMapper($pdo, $postCommentMapper);

        // Shared
        $application->add(new ExecuteDatabaseImportCommand($pdo));

        // Blog
        $application->add(new ListBlogPostsCommand($postMapper));
        $application->add(new FindBlogPostByIdCommand($postMapper));

        $application->run();
    }
}
