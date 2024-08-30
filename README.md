# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

### 1.1. Консольная команда для правильных скобок
```php
 curl -X POST http://mysite.local -d "string=(()()()(()(()))())"
```
### 1.2. Консольная команда для неправильных скобок
```php
 curl -X POST http://mysite.local -d "string=(()()()(()(()))()))"
```
### 1.3. Консольная команда для пустого запроса
```php
 curl -X POST http://mysite.local -d "string"
```
### 1.4. Консольная команда для недопустимого метода
```php
 curl -X GET http://mysite.local -d "string"
```
### 2. Каждый раз когда обновляем страницу или делаем curl-запрос в консли, то будет выводиться разные имя хостов
```php
 Имя хоста: php2-host
 Метод не разрешен.
```