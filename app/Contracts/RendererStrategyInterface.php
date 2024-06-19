<?php

namespace App\Contracts;

use App\Template;

interface RendererStrategyInterface
{
    public function addRow(Template $template): void;
}
