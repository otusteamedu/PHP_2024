<?php

namespace App\Contracts;

use App\Template;

interface FolderItemInterface
{
    public function render(Template $template): void;
}
