<?php

require 'vendor/autoload.php';

use Service\AuthorMapper;
use Service\BookMapper;
use Service\DatabaseConnection;

$databaseConnection = new DatabaseConnection();

$authorMapper = new AuthorMapper($databaseConnection);
$bookMapper = new BookMapper($databaseConnection);

$author = $authorMapper->find(1);
$books = $bookMapper->findAllByAuthorId($author->getId());

echo $author->getName() . ' ' . $author->getLastname();
echo '<br/><br/>';

foreach ($books as $book) {
    echo $book->getName();
    echo '<br/>';
}
