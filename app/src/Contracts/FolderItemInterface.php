<?php

namespace App\src\Contracts;

use App\src\Template;

interface FolderItemInterface
{
    public function render(Template $template): void;
}
