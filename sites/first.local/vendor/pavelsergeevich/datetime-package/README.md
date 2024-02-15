# Обертка DateTime
Расширение возможностей \DateTime

## Требования

- PHP >= 5.2.0

## Установка

```bash
composer require pavelsergeevich\test-composer-package
```

## Использование 
```php
use \Pavelsergeevich\DatetimePackage\CustomDateTime;

$customDateTime = new CustomDateTime();
$startWeek = $customDateTime->getStartWeek(CustomDateTime::FORMAT_MYSQL);

echo "Понедельник текущий недели: $startWeek";
```