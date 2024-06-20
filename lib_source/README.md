# Chinese Zodiac

A package to determine the Chinese zodiac sign for a given year.

## Requirements

- PHP 8.2 or higher

## Installation

You can install the package via Composer:

```bash
composer require your-vendor-name/chinese-zodiac
```

## USAGE

```bash
<?php
require 'vendor/autoload.php';

use YourVendorName\ChineseZodiac\ChineseZodiac;

// Create an instance of the ChineseZodiac class
$zodiac = new ChineseZodiac();

// Get the zodiac sign for a specific year
echo $zodiac->getZodiac(2024); // Output: Dragon