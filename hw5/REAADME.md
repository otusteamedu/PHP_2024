## Как пользоваться
в корне, .env-example скопировать в .env и прописать желаемые настройки.  
В файле it_work.php можно убедиться, что:
  - происходит переключение между нодами nginx (строка "Адрес nginx: 192.168.240.7" меняется)
  - происходит переключение между нодами php (строка "PHP host: 7415370ad7a5" меняется)
  - сессия не сбоит при переходе между нодами nginx/php (счетчик растет при каждом обновлении страницы)
  - redis/memcached доступны из кода пхп (это так, в нагрузку к коду)

В файле mysql.php можно убедиться, что эта БД работает. (mysql был на схеме ДЗ, в презентации, на уроке) 

### Добавление еще одной ноды nginx
В docker-compose.yaml скопировать секцию и подправить:
```dockerfile
#нарастить
  nginx_fpm2: 
    depends_on:
      - php1
      - php2
    build:
      context: nginx_fpm
      dockerfile: Dockerfile
    image: hw5_nginx_fpm
#нарастить
    container_name: hw5_nginx_fpm_2 #нарастить
    volumes:
       - ./code:/data/site_root
#нарастить
       - ./logs/nginx_fpm2:/var/log/nginx
    networks:
      - hw5_network
```
nginx_balancer/hosts/site.conf - добавить новый сервер по аналогии.

### Добавление еще одной ноды php
В docker-compose.yaml скопировать секцию и подправить:
```dockerfile
#нарастить
  php2:
    build:
      context: php
      dockerfile: Dockerfile
      args:
        XDEBUG_REMOTE_IP: ${XDEBUG_REMOTE_IP}
        MYSQL_DATABASE: ${MYSQL_DATABASE}
        MYSQL_USER: ${MYSQL_USER}
        MYSQL_PASSWORD: ${MYSQL_PASSWORD}
    image: hw5_php
#нарастить
    container_name: hw5_php_2
    volumes:
       - ./code:/data/site_root
       - ./logs/php:/var/log/php
    networks:
      - hw5_network
```
В docker-compose.yaml, в каждой из секций nginx_fpm2*, добавить новый контейнер в зависимости.  
nginx_fpm/hosts/site.conf - добавить новую ноду по аналогии. 
