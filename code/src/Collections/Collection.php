<?php

namespace Naimushina\ElasticSearch\Collections;

class Collection
{
    protected array $items = array();

    public function addItem($obj, $key = null) {
        $this->items[] = $obj;
    }



}