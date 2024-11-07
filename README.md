# Homestead + vagrant + virtualbox

Проверьте ваши ключи ssh они должны присутствовать, путь по умолчанию: ~/.ssh/id_rsa
Либо сгенерируйте с помощью команды:
```
ssh-keygen -t rsa -b 4096 -C your_email@example.com
```

## Установка и запуск

У вас должен быть установлен virtualbox, vagrant

В папке Homestead выполняете команду:

```
bash init.sh
```

Для вас сгенерируется файл Homestead.yaml

Настройки по умолчанию:

```
ip: "сгенерируется"
memory: сгенерируется
cpus: сгенерируется
provider: virtualbox - ваш провайдер

authorize: ~/.ssh/id_rsa.pub

keys:
  - ~/.ssh/id_rsa

folders:
  - map: Ваш путь к файлам ларавеля
    to: /home/vagrant/code

sites:
  - map: application.local
    to: /home/vagrant/code/public
```

После настройки в папке Homestead выполняете команду:

```
vagrant up - для запуска сервера

vagrant halt - для остановки машины
```

## Доступ к приложению

URL: http://application.local
