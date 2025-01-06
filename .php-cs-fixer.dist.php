<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__ . '/src/')
    ->exclude('vendor');

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
    ])->setFinder($finder);
