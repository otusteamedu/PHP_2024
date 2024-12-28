Необходимо реализовать один из паттернов: 
Table Data Gateway, 
Raw Data Gateway,
Active Record, 
DataMapper для произвольной таблицы.


Паттерн должен содержать метод массового получения информации из таблицы, результат которого возвращается в виде коллекции.


Дополнительно можно использовать паттерн Identity Map для устранения дублирования объектов, 
ссылающихся на одну строку в БД или Lazy Load для отложенной загрузки связанных записей в таблице или коллекции.


Критерии оценки:
Основная задача - реализация одного из перечисленных паттернов на произвольной таблице.
Желательно реализовать метод массового получения информации.
Желательно реализовать один из паттернов: Identity Map или Lazy Load.

## Развертывание
### Сборка
Установка переменных .env.
```shell script
cp ./.env.example .env &&

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
### Добавление Доктора
```shell script
php index.php add_doctor '{"fullName":"Докторов Доктор Докторович","cabinet":1,"position":"Терапевт"}'
```

### Добавление Пациента
```shell script
php index.php add_patient '{"fullName":"Пациентов Пациент Пациентович","bithday":"1992-09-03","phone":"+79144705440"}'
```

### Добавление Исследования
```shell script
php index.php add_study '{"patient_id":1,"medic_id":1,"diagnoses":"Диагноз","study_memo":"Такие то жалобы, такая та температура и тд","study_date":"2024-12-24"}'
```
### Получить список исследований
```shell script
php index.php get_studies
```

