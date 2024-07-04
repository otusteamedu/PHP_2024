# PHP_2024

1. copy **.env.sample** as **.env** in docker-fpm folder

2. `docker compose up -d` (from docker-fpm folder)

3. check http://127.0.0.1:9091/ is working (use port you need from .env)

4. `docker exec -it hw1_php-fpm bash` (if you changed container name, use it)

5. execute `composer update`


if you want you can add any package you want using `composer require package/name` in container

if you want to remove vendor folder, you should do it from container

http files in `/www` folder

>package repository: https://github.com/sergey-program/composer-package-slugify 

>public packagist page: https://packagist.org/packages/sergey-program/otus-composer-package-slugify


there are `compose.yaml` and `docker-compose.yaml` for docker 2.x and docker 1.x version
