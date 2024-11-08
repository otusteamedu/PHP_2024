# Сложение и поиск 3х популярных городов

После скачивания репозитория сделайте файлы 'famous_cities.sh' и 'sum.sh' - исполняемыми с помощью команды:
```bash
    chmod +x famous_cities.sh
    chmod +x sum.sh
```

## Сложение двух чисел

Впишите исполняемый файл 'sum.sh' и два аргумента для сложения:

```bash
./sum.sh -5.33 -7.01

```
- Получите результат: 'Сумма чисел -5.33 + -7.01 = -12.34'

## Поиск 3х популярных городов

Впишите исполняемый файл 'famous_cities.sh' и аргументом адрес файла например 'list_cities.txt':

```bash
./famous_cities.sh list_cities.txt

```

```txt
id user city phone
1 test Moscow 1234123
2 test2 Saint-P 1232121
3 test3 Tver 4352124
4 test4 Milan 7990923
5 test5 moscow 908213
6 test6 Milan 7990923
7 test7 Moscow 908213
8 test8 milan 7990923
9 test9 moscow 908213
10 test10 saint-P 1232121
11 test11 Tver 4352124
12 test12 milan 7990923
13 test13 Moscow 908213
14 test15 Milan 7990923
16 test16 Moscow 908213
17 test17 milan 7990923
18 test18 Moscow 908213
19 test19 Saint-P 1232121
20 test20 tver 4352124
```

- Получите результат: 
    - Moscow
    - Milan
    - Tver
