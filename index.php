<?php
    require __DIR__ . '/vendor/autoload.php';

    use Timmy010\FakePost\FakePost;

    $postInstance = new FakePost();
    $post = $postInstance->getPost();
?>

<article>
    <h2><?=$post['title']?></h2>
    <p><?=$post['body']?></p>
</article>