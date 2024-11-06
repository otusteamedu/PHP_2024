# Урок 21. Архитектура кода (Д.З. 15)

Содержание:

- [Описание](#описание)
- [Использование](#использование)

## Описание

### Домашнее задание: система медиамониторинга

Вам нужно разработать REST API (только backend!) для системы, которая поможет собирать информацию и готовить
сводные отчёты о новостных публикациях в Интернете.

### Пользовательские сценарии:

**Добавление новости**.

В систему передаётся URL новостного материала в Интернете. Система скачивает HTML по этому URL и создаёт на его основе
сущность со следующими полями:

- дата (текущая дата)
- URL (нам его передали в запросе)
- название новости (его проще всего взять из тега title)

В ответ возвращается ID сущности.

**Получение списка новостей**.

Система возвращает список (массив) ранее созданных сущностей с полями:

- ID
- дата
- URL
- название новости

**Формирование сводного отчёта**.

В систему передаётся массив из нескольких ID. Система формирует и сохраняет на диск простой HTML-файл со списком
примерно такого вида:

```html

<ul>
    <li><a href="...">Заголовок новости 1</a></li>
    <li><a href="...">Заголовок новости 2</a></li>
</ul>
```

В ответ возвращается ссылка на этот файл.

### Важные замечания:

1) Вам нужно самостоятельно продумать всё, что касается архитектуры этого приложения. Если будут вопросы — задавайте. Не
   бойтесь допускать ошибки: весь смысл домашки в том, чтобы потом их обсудить и исправить.

2) Вы можете взять за основу любой фреймворк, но обращаться к методам и классам фреймворка можно только на слое
   Infrastructure. Другими словами, ни на слое Domain, ни на слое Application не должно использоваться ничего, кроме
   написанных вами классов.

3) Для хранения сущностей вы можете использовать БД или файловую систему, это не принципиально, но — см. предыдущее
   замечание.

## Использование

### Установка

Создание файла с переменными окружения:

```shell
cp .env.dist .env && cp app/.env.dist app/.env 
```

Запустить Docker контейнеры:

```shell
make up
```

Запустить миграции:

```shell
make doctrine-migrate
```

### API

**Создание поста**

Пример запроса:

```http request
POST /api/v1/posts

{
  "url": "https://google.com"
}
```

Пример ответа:

```json
{
    "id": 1
}
```

**Получение списка постов**

Пример запроса:

```http request
GET /api/v1/posts
```

Пример ответа:

```json
[
    {
        "id": 1,
        "title": "Google",
        "date": {
            "date": "2024-11-06 17:19:34.000000",
            "timezone_type": 3,
            "timezone": "UTC"
        },
        "url": "https://google.com"
    }
]
```

**Генерация отчета**

Пример запроса:

```http request
POST /api/v1/reports

{
  "postIds": [1]
}
```

Пример ответа:

```json
{
    "url": "http://localhost:8080/reports/download/1"
}
```

