# Развёртывание приложения

## Настраиваем виртуальную машину

1. Заходим в виртуалку и устанавливаем окружение командами (команды для ubuntu 20.04)
    ```shell
    sudo apt install software-properties-common
    sudo add-apt-repository ppa:ondrej/php
    sudo apt update
    sudo apt install curl git unzip nginx postgresql postgresql-contrib rabbitmq-server supervisor memcached libmemcached-tools redis-server php8.2-cli php8.2-fpm php8.2-common php8.2-mysql php8.2-zip php8.2-gd php8.2-mbstring php8.2-curl php8.2-xml php8.2-bcmath php8.2-pgsql php8.2-memcached php8.2-redis php8.2-igbinary php8.2-msgpack
    ```
2. Устанавливаем composer
    ```shell
    curl -sS https://getcomposer.org/installer -o composer-setup.php
    sudo php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    ```
3. Создаём БД командами
    ```shell
    sudo -u postgres bash -c "psql -c \"CREATE DATABASE rest_api ENCODING 'UTF8' TEMPLATE = template0\""
    sudo -u postgres bash -c "psql -c \"CREATE USER user1 WITH PASSWORD 'password1'\""
    sudo -u postgres bash -c "psql -c \"GRANT ALL PRIVILEGES ON DATABASE rest_api TO user1\""
    ```
4. Разрешаем доступ к БД снаружи
    1. В файл `/etc/postgresql/12/main/pg_hba.conf` добавляем строки
        ```
        host    all     all     0.0.0.0/0       md5
        host    all     all     ::/0            md5
        ```
    2. В файле `/etc/postgresql/12/main/postgresql.conf` находим закомментированную строку с параметром
       `listen_addresses` и заменяем её на
        ```
        listen_addresses='*'
        ```
    3. Перезапускаем сервис `postgresql` командой `sudo service postgresql restart`
5. Проверяем, что по порту 5432 можем попасть в БД twitter с реквизитами my_user / 1H8a61ceQW7htGRE6iVz
6. Конфигурируем RabbitMQ командами (по одной команде за раз)
    ```shell
    sudo rabbitmq-plugins enable rabbitmq_management 
    sudo rabbitmq-plugins enable rabbitmq_consistent_hash_exchange
    sudo rabbitmqctl add_user user1 password1
    sudo rabbitmqctl set_user_tags user1 administrator
    sudo rabbitmqctl set_permissions -p / user1 ".*" ".*" ".*"
    ```
7. Проверяем, что по порту 15672 можем залогиниться с указанными кредами
8. Дадим права на работу с каталогом `var/www` всем командой `sudo chmod 777 /var/www`
9. В файле `/etc/nginx/nginx.conf` исправляем строку (актуально для AWS EC2)
    ```
    server_name_hash_bucket_size 128;
    ```
10. Перезапускаем nginx командой `sudo service nginx restart`
11. В файл `/etc/sudoers` добавляем строку
     ```
     www-data ALL=(ALL) NOPASSWD:ALL
     ```

## Добавляем скрипт развёртывания

1. Переносим код в Gitlab:
    1. заводим новый репозиторий на GitLab
    2. клонируем его
    3. помещаем туда код проекта
    4. пушим правки в репозиторий
2. В репозитории в GitLab
    1. заходим в раздел `Settings -> CI / CD` и добавляем переменные окружения
        1. `SERVER1` - адрес сервера
        2. `SSH_USER` - имя пользователя для входа по ssh (для YandexCloud - `alexander`)
        3. `SSH_PRIVATE_KEY` - приватный ключ, закодированный в base64
        4. `DATABASE_HOST` - `localhost`
        5. `DATABASE_NAME` - `rest_api`
        6. `DATABASE_USER` - `user1`
        7. `DATABASE_PASSWORD` - `password1`
        8. `RABBITMQ_HOST` - `localhost`
        9. `RABBITMQ_USER` - `user1`
        10. `RABBITMQ_PASSWORD` - `password1`
    2. заходим в раздел `Settings -> Repository` и добавляем deploy token с правами `read_repository`, сохраняем пароль
3. Создаём файл `deploy/nginx.conf`
    ```
    server {
        listen 80;
    
        server_name %SERVER_NAME%;
        error_log  /var/log/nginx/error.log;
        access_log /var/log/nginx/access.log;
        root /var/www/hw21/public;
    
        rewrite ^/index\.php/?(.*)$ /$1 permanent;
    
        try_files $uri @rewriteapp;
    
        location @rewriteapp {
            rewrite ^(.*)$ /index.php/$1 last;
        }
    
        # Deny all . files
        location ~ /\. {
            deny all;
        }
    
        location ~ ^/index\.php(/|$) {
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_index index.php;
            send_timeout 1800;
            fastcgi_read_timeout 1800;
            fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        }
    }
    ```
4. Создаём файл `deploy/supervisor.conf`
    ```
    [program:add_followers]
    command=php /var/www/demo/bin/console rabbitmq:consumer -m 1000 add_followers --env=dev -vv
    process_name=add_follower_%(process_num)02d
    numprocs=1
    directory=/tmp
    autostart=true
    autorestart=true
    startsecs=3
    startretries=10
    user=www-data
    redirect_stderr=false
    stdout_logfile=/var/www/demo/var/log/supervisor.add_followers.out.log
    stdout_capture_maxbytes=1MB
    stderr_logfile=/var/www/demo/var/log/supervisor.add_followers.error.log
    stderr_capture_maxbytes=1MB

    ```
5. Исправляем файл `.env`
    ```shell
    # In all environments, the following files are loaded if they exist,
    # the latter taking precedence over the former:
    #
    #  * .env                contains default values for the environment variables needed by the app
    #  * .env.local          uncommitted file with local overrides
    #  * .env.$APP_ENV       committed environment-specific defaults
    #  * .env.$APP_ENV.local uncommitted environment-specific overrides
    #
    # Real environment variables win over .env files.
    #
    # DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.
    # https://symfony.com/doc/current/configuration/secrets.html
    #
    # Run "composer dump-env prod" to compile .env files for production use (requires symfony/flex >=1.2).
    # https://symfony.com/doc/current/best_practices.html#use-environment-variables-for-infrastructure-configuration
    
    ###> symfony/framework-bundle ###
    APP_ENV=dev
    APP_SECRET=b9af0c0839126e827225990ff6aa8c9b
    ###< symfony/framework-bundle ###
    
    ###> doctrine/doctrine-bundle ###
    DATABASE_URL="postgresql://%DATABASE_USER%:%DATABASE_PASSWORD%@%DATABASE_HOST%:5432/%DATABASE_NAME%?serverVersion=11&charset=utf8"
    ###< doctrine/doctrine-bundle ###
    
    RABBITMQ_HOST=%RABBITMQ_HOST%
    RABBITMQ_PORT=5672
    RABBITMQ_USERNAME=%RABBITMQ_USER%
    RABBITMQ_PASSWORD=%RABBITMQ_PASSWORD%
    ```
6. Создаём файл `deploy.sh`
    ```shell
    sudo cp deploy/nginx.conf /etc/nginx/conf.d/hw21.conf -f
    sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/hw21.conf -f
    sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/hw21.conf
    sudo service nginx restart
    cd app
    sudo -u www-data composer install -q
    sudo service php8.2-fpm restart
    sudo -u www-data sed -i -- "s|%DATABASE_HOST%|$2|g" .env
    sudo -u www-data sed -i -- "s|%DATABASE_USER%|$3|g" .env
    sudo -u www-data sed -i -- "s|%DATABASE_PASSWORD%|$4|g" .env
    sudo -u www-data sed -i -- "s|%DATABASE_NAME%|$5|g" .env
    sudo -u www-data php bin/console doctrine:migrations:migrate --no-interaction
    sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$6|g" .env
    sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$7|g" .env
    sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$8|g" .env
    sudo service supervisor restart
    ```
7. Создаём файл `.gitlab-ci.yml` (не забудьте указать корректный путь к репозиторию в git clone и креды)
    ```yml
    before_script:
      - apt-get update -qq
      - apt-get install -qq git
      - 'which ssh-agent || (apt-get install -qq openssh-client )'
      - eval $(ssh-agent -s)
      - ssh-add <(echo "$SSH_PRIVATE_KEY" | base64 -d)
      - mkdir -p ~/.ssh
      - echo -e "Host *\n\tStrictHostKeyChecking no\n\n" > ~/.ssh/config
    
    deploy_server1:
      stage: deploy
      environment:
        name: server1
        url: $SERVER1
      script:
        - ssh $SSH_USER@$SERVER1 "sudo rm -rf /var/www/hw21 &&
          cd /var/www &&
          git clone https://alexander:gldt-_rkJqbizs4Yin1QJsLo7@gitlab.com/learn5014125/hw21.git hw21 &&
          sudo chown www-data:www-data hw21 -R &&
          cd hw21 &&
          sh ./deploy.sh $SERVER1 $DATABASE_HOST $DATABASE_USER $DATABASE_PASSWORD $DATABASE_NAME $RABBITMQ_HOST $RABBITMQ_USER $RABBITMQ_PASSWORD"
      only:
        - main
    
    ```
8. Добавляем код в main-ветку и пушим в GitLab
9. В репозитории в GitLab в разделе `CI / CD -> Pipelines` можно следить за процессом
10. Проверяем в интерфейсе RabbitMQ, что консьюмеры запустились
11. Выполняем запрос из Postman-коллекции 

## Переходим на blue-green deploy

1. На сервере
    1. удаляем на сервере содержимое каталог `/var/www/hw21`
    2. создаём каталог `/var/www/hw21/shared/log`
    3. выполняем команду `sudo chmod 777 /var/www/hw21 -R`
2. Исправляем файл `deploy/nginx.conf`
    ```
    server {
        listen 80;
    
        server_name %SERVER_NAME%;
        error_log  /var/log/nginx/error.log;
        access_log /var/log/nginx/access.log;
        root /var/www/hw21/current/app/public;
    
        rewrite ^/index\.php/?(.*)$ /$1 permanent;
    
        try_files $uri @rewriteapp;
    
        location @rewriteapp {
            rewrite ^(.*)$ /index.php/$1 last;
        }
    
        # Deny all . files
        location ~ /\. {
            deny all;
        }
    
        location ~ ^/index\.php(/|$) {
            fastcgi_split_path_info ^(.+\.php)(/.*)$;
            include fastcgi_params;
            fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
            fastcgi_param PATH_INFO $fastcgi_path_info;
            fastcgi_index index.php;
            send_timeout 1800;
            fastcgi_read_timeout 1800;
            fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        }
    }
    ```
3. Исправлям файл `deploy/supervisor.conf`
    ```
    [program:task_consumer_start]
    command=php /var/www/hw21/current/app/bin/console task-consumer:start
    process_name=task_consumer_start_%(process_num)02d
    numprocs=1
    directory=/tmp
    autostart=true
    autorestart=true
    startsecs=3
    startretries=10
    user=www-data
    redirect_stderr=false
    stdout_logfile=/var/www/hw21/current/app/var/log/supervisor.task_consumer_start.out.log
    stdout_capture_maxbytes=1MB
    stderr_logfile=/var/www/hw21/current/app/var/log/supervisor.task_consumer_start.error.log
    stderr_capture_maxbytes=1MB
    ```
4. Исправляем `.gitlab-ci.yml`
    ```yaml
    before_script:
      - apt-get update -qq
      - apt-get install -qq git
      - 'which ssh-agent || (apt-get install -qq openssh-client )'
      - eval $(ssh-agent -s)
      - ssh-add <(echo "$SSH_PRIVATE_KEY" | base64 -d)
      - mkdir -p ~/.ssh
      - echo -e "Host *\n\tStrictHostKeyChecking no\n\n" > ~/.ssh/config
      - export DIR=$(date +%Y%m%d_%H%M%S)
    
    deploy_server1:
      stage: deploy
      environment:
        name: server1
        url: $SERVER1
      script:
        - ssh $SSH_USER@$SERVER1 "cd /var/www/hw21 &&
          git clone https://alexander:gldt-_rkJqbizs4Yin1QJsLo7@gitlab.com/learn5014125/hw21.git $DIR &&
          sudo chown www-data:www-data $DIR -R &&
          cd $DIR &&
          sh ./deploy.sh $SERVER1 $DATABASE_HOST $DATABASE_USER $DATABASE_PASSWORD $DATABASE_NAME $RABBITMQ_HOST $RABBITMQ_USER $RABBITMQ_PASSWORD &&
          cd .. &&
          rm -rf /var/www/hw21/$DIR/var/log &&
          ln -s /var/www/hw21/shared/log /var/www/hw21/$DIR/var/log &&
          ( [ ! -d /var/www/hw21/current ] || mv -Tf /var/www/hw21/current /var/www/hw21/previous ) &&
          ln -s /var/www/hw21/$DIR /var/www/hw21/current"
      only:
        - main
    ```
   
5. Пушим код в репозиторий

## Добавляем rollback

1. Добавляем файл `rollback.sh`
    ```shell
    sudo cp deploy/nginx.conf /etc/nginx/conf.d/hw21.conf -f
    sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/hw21.conf -f
    sudo sed -i -- "s|%SERVER_NAME%|$1|g" /etc/nginx/conf.d/hw21.conf
    sudo service nginx restart
    sudo service php8.2-fpm restart
    sudo -u www-data php app/bin/console cache:clear
    sudo service supervisor restart
    ```
2. Ещё раз исправляем `.gitlab-ci.yml`
    ```yaml
    stages:
      - deploy
      - rollback

    before_script:
      - apt-get update -qq
      - apt-get install -qq git
      - 'which ssh-agent || ( apt-get install -qq openssh-client )'
      - eval $(ssh-agent -s)
      - ssh-add <(echo "$SSH_PRIVATE_KEY" | base64 -d)
      - mkdir -p ~/.ssh
      - echo -e "Host *\n\tStrictHostKeyChecking no\n\n" > ~/.ssh/config
      - export DIR=$(date +%Y%m%d_%H%M%S)
    
    deploy_server1:
      stage: deploy
      environment:
        name: server1
        url: $SERVER1
      script:
        - ssh $SSH_USER@$SERVER1 "cd /var/www/demo &&
          git clone https://deploy:ZsZAGdePfH2QCoBYQkh2@gitlab.com/raptor-mvk/deploy-test.git $DIR &&
          sudo chown www-data:www-data $DIR -R &&
          cd $DIR &&
          sh ./deploy.sh $SERVER1 $DATABASE_HOST $DATABASE_USER $DATABASE_PASSWORD $DATABASE_NAME $RABBITMQ_HOST $RABBITMQ_USER $RABBITMQ_PASSWORD
          cd .. &&
          rm -rf /var/www/demo/$DIR/var/log &&
          ln -s /var/www/demo/shared/log /var/www/demo/$DIR/var/log &&
          ( [ ! -d /var/www/demo/current ] || mv -Tf /var/www/demo/current /var/www/demo/previous ) &&
          ln -s /var/www/demo/$DIR /var/www/demo/current"
      only:
        - main
   
    rollback:
      stage: rollback
      script:
        - ssh $SSH_USER@$SERVER1 "unlink /var/www/hw21/current &&
              mv -Tf /var/www/demo/previous /var/www/hw21/current &&
              cd /var/www/hw21/current &&
              sh ./rollback.sh $SERVER1"
      when: manual
    ```
   
