<?php

namespace Naimushina\ElasticSearch\Collections;

use Naimushina\ElasticSearch\Entities\Book;

class BookCollection extends Collection
{
    public function __construct(array $books = [])
    {
        foreach ($books as $book) {
            $this->addItem(new Book(...$book));
        }
    }



    public function getItemsToShow($columns = [])
    {
        return array_map(function (Book $item) {
            $count = $item->getCount();
            $itemInfo = $item->toArray(['title', 'category', 'price']);
            $itemInfo ['count'] = $count;
            return $itemInfo ;
        }, $this->items);
    }
}
