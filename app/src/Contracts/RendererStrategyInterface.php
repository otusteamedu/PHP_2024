<?php

namespace App\src\Contracts;

use App\src\Template;

interface RendererStrategyInterface
{
    public function addRow(Template $template): void;
}
