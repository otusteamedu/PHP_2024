# PartStringHighlight

Библиотека PartStringHighlight позволяет найти подстроку в строке и вернуть данную 
строку с выделенной посредством скобок () подстрокой. Регистр строк УЧИТЫВАЕТСЯ.


## Требования

- PHP 8.0


## Установка

```bash
composer require alex-s-otus/composer-homework
```

## Usage

```php
<?php
$stringHighlight = new \AlexSOtus\ComposerHomework\PartStringHighlight();
echo $stringHighlight->stringHighlight("abc","a");
```
