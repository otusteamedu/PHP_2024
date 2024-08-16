<?php

require_once "vendor/autoload.php";

use Sukhov\Slugger\Slugger;

$slug = Slugger::urlToSlug('Lorem ipsum dolor sit amet, consectetur adipiscing elit');
echo $slug;