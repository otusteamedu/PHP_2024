# Консольные команды

## Создание индекса
```bash
php index.php create-index
```

## Удаление индекса
```bash
php index.php delete-index
```

## Массовое создание документов
```bash
php index.php bulk files/books_39289_aa67f1_39289_6891db-471917-5955c0.json
```

## Получение документа
```bash
php index.php index.php get-doc 500-000
```

## Обновление документа
```bash
php index.php update-doc 500-000 '{"price": 500}'
```

## Удаление документа
```bash
php index.php delete-doc 500-000
```

## Поиск
```bash
php index.php search '{"query":{"match_all":{}}}'
php index.php search '{"query":{"match":{"category": "Сад и огород"}}}'
```
