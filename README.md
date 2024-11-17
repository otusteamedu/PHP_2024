# Redis

Добавим информацию о сотруднике
```shell
php app.php add '{"Name":"Степанов Акрадий Геннадьевич","Priority":0,"Params":{"photo":"img0.png","position":"Генеральный Директор","department":"ОАО «Купи-Продай»","phone":"777-000"}}'
```

Добавим информацию обо всех сотрудниках
```shell
php app.php bulk '[{"Name":"Иванов Евгений Вмитриевич","Priority":2,"Params":{"photo":"img1.png","position":"Руководитель","department":"Отдел Маркетинга","phone":"777-001","projects":["реклама","стратегия развития"]}},{"Name":"Вязов Сергей Фёдорович","Priority":4,"Params":{"photo":"img7.png","position":"Специалист","department":"Отдел Маркетинга","phone":"777-007","projects":["группа в вк","группа в телеграме","визитки"]}},{"Name":"Сидоров Акрадий Геннадьевич","Priority":1,"Params":{"photo":"img2.png","position":"Руководитель","department":"Коммерческий отдел","phone":"777-002","profit":350000,"expenses":250000}},{"Name":"Волков Сергей Эдуардович","Priority":5,"Params":{"photo":"img3.png","position":"Специалист","department":"Коммерческий отдел","phone":"777-003","profit":100000}},{"Name":"Шишкин Семён Игорьевич","Priority":5,"Params":{"photo":"img4.png","position":"Специалист","department":"Коммерческий отдел","phone":"777-004","profit":150000}},{"Name":"Жидков Егор","Priority":5,"Params":{"photo":"img5.png","position":"Специалист","department":"Коммерческий отдел","phone":"777-005","profit":75000}},{"Name":"Нерезов Данил Геннадьевич","Priority":3,"Params":{"photo":"img6.png","position":"Специалист по закупкам","department":"Коммерческий отдел","phone":"777-006","expenses":200000}}]'
```
Кто главный?
```shell
php app.php  search '{"position":"Директор"}'
```
![Filter example](/imgs/1.png)

Все сотрудники
```shell
php app.php  search '{"Name":""}'

```
![Filter example](/imgs/2.png)

Все сотрудники коммерческого отдела
```shell
php app.php  search '{"department":"Коммерческий отдел"}'
```
![Filter example](/imgs/3.png)

Все специалисты коммерческого отдела
```shell
php app.php  search '{"department":"Коммерческий отдел","position":"Специалист"}'
```
![Filter example](/imgs/4.png)

Очистим БД
```shell
php app.php clear
```