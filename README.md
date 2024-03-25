# PHP_2024

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

## Quickstart

1. [Install git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
2. [Install docker](https://docs.docker.com/install/)
3. [Install docker-compose](https://docs.docker.com/compose/install/)
4. [Install make](https://wiki.ubuntu.com/ubuntu-make)

```
cp .env.example .env
#Add mapping ports for redis, musql, memcached
```

###Run via console

```
docker-compose up -d --build
docker-compose exec app bash
composer install
```

###Run via make

```
make start-otus
```

##Usage 
```
docker-compose run app php frontend/web/index.php init
docker-compose run app php frontend/web/index.php test
docker-compose run app php frontend/web/index.php search '{
    "query": {
        "match": {
            "title": "Кто подставил Терминатора"
        }
    }
}'
docker-compose run app php frontend/web/index.php search '{
    "query": {
        "match": {    
            "title": {
                "query": "Терменатора",
                "fuzziness": "auto"
            } 
        }
    }
}'
docker-compose run app php frontend/web/index.php search '{
    "query": {
        "bool": {
            "must": [
                {
                    "match": {
                        "title": {
                        "query": "РыцОри",
                        "fuzziness": "auto"
                    }
                    }
                }
            ],
            "filter": [
                {
                    "range": {
                        "price": {
                            "lt": 2000
                        }
                    }
                }
            ]
        }
    }
}'
```
or

```
docker-compose exec app bash
php frontend/web/index.php index.php init
php frontend/web/index.php index.php test
php frontend/web/index.php index.php search '{
    "query": {
        "match": {
            "title": "Кто подставил Терминатора"
        }
    }
}'
php frontend/web/index.php index.php search '{
    "query": {
        "match": {    
            "title": {
                "query": "Терменатора",
                "fuzziness": "auto"
            } 
        }
    }
}'
php frontend/web/index.php index.php search '{
    "query": {
        "bool": {
            "must": [
                {
                    "match": {
                        "title": {
                        "query": "РыцОри",
                        "fuzziness": "auto"
                    }
                    }
                }
            ],
            "filter": [
                {
                    "range": {
                        "price": {
                            "lt": 2000
                        }
                    }
                }
            ]
        }
    }
}'

```
