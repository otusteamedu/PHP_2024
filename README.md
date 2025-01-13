# PHP_2024
Пишем приложение обработки отложенных запросов.


1. Создать простое веб-приложение, принимающее POST запрос из формы от пользователя. 
2. Например, запрос на генерацию банковской выписки за указанные даты.

1.1. Обычно такие запросы (в реальных системах) работают довольно долго, 
поэтому пользователя надо оповестить о том, что запрос принят в обработку

1.2. Форма должна подразумевать отправку оповещения по результатам работы

2. Передать тело запроса в очередь

3. Написать скрипт, который будет читать сообщения из очереди и выводить информацию о них в консоль

4*. Реализация оповещения

4.1. Сгенерированный ответ отправить через email или telegram


Приложить инструкцию по запуску системы


Критерии оценки:
Работоспособность решения (5 баллов)
Чистота кода (3 балла)
Инструкции по развёртыванию системы (2 балла)

## Развертывание
### Сборка
Установка переменных .env.
```shell script
cp ./.env.dev .env &&

```
Сборка контейнеров
```shell script
docker-compose build
```

### Запуск контейнеров
```shell script
docker-compose up -d &&
docker-compose exec app bash -c "export COMPOSER_HOME=/data/mysite.local && composer install" 
```
### Наполнение базы
```shell script
docker-compose exec app bash -c "php bin/console doctrine:migrations:migrate" 
```
### Запуск обработчика очереди 
```shell script
docker-compose exec app bash -c "php bin/console rabbitmq:consumer statement -m 100 " 
```

### Создание Аккаунта
Отправляем запрос для создания аккаунта(можно использовать запрос create_account из postman collection)
POST запрос http://mysite.local/api/v1/account/add
#### Request Body
```json
{
  "holderName": "name",
  "holderEmail":"my_email@mail.ru"
}
```
```shell script
curl --location 'http://mysite.local/api/v1/account/add' \
--form 'holderName="name"' \
--form 'holderEmail="my_email@mail.ru"'
```
В ответе придет аккаунта который нужно запомнить так как после именно с ним мы будем работать
### Генерация транзакций
Для проверки создания банковской выписки сгенерируем 1000 транзакций для только что созданного аккаунта

```shell script
docker-compose exec app bash -c "php bin/console  app:generate-transactions 1 1000" 
```
где 1 - это номер аккаунта
1000 - количество транзакций которые хотим сгенерировать

### Запрос на генерацию банковской выписки за указанные даты
POST запрос http://mysite.local/api/v1/statement/get
#### Request Body
```json
{
  "accountNumber": 1,
  "dateFrom":"2025-01-07",
  "dateTo":"2025-01-07"
  
}
```
```shell script
curl --location 'http://mysite.local/api/v1/statement/get' \
--form 'accountNumber="1"' \
--form 'dateFrom="2025-01-07"' \
--form 'dateTo="2025-01-07"'
```