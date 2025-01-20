# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Usage

`cp .env.example .env`

`docker-compose up -d`

`docker exec -it php-fpm /bin/bash -c 'composer dump-autoload --optimize'`

Navigate to `http://localhost:8080/`

### Сложность (Big O)
Сложность метода `PhoneLetterCombinationSolution@phoneLetterCombinations` равна O(n*m), где n — количество символов в строке `digits`, а m — количество букв, соответствующих одной цифре (максимально 4).
