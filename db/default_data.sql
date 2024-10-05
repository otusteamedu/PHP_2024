TRUNCATE "films" RESTART IDENTITY CASCADE;
INSERT INTO "films" (name, original_name, release_date, rating, duration, description)
    VALUES
        ('Дюна 2', 'Dune: Part Two', '2024-02-06', 8.3, 166, 'Герцог Пол Атрейдес присоединяется к фременам, чтобы стать Муад Дибом, одновременно пытаясь остановить наступление войны.'),
        ('Дэдпул и Росомаха', 'Deadpool & Wolverine', '2024-07-22', 7.5, 128, 'Уэйд Уилсон попадает в организацию «Управление временными изменениями», что вынуждает его вернуться к своему альтер-эго Дэдпулу и изменить историю с помощью Росомахи.'),
        ('Бременские музыканты', null, '2024-01-01', 6.7, 116, 'Трубадур и его друзья-самозванцы — Пес, Кошка, Осел и самовлюбленный Петух — объединились, чтобы совершить подвиг. Прежде всего они должны рассмешить дочь Короля, но встреча с Принцессой грозит опасным приключением.'),
        ('Кунг-фу Панда 4', 'Kung Fu Panda 4', '2024-03-02', 6.7, 94, 'Продолжение приключений легендарного воина По, его верных друзей и наставника.'),
        ('Мастер и Маргарита', null, '2024-01-25', 7.7, 157, 'Москва, 1930-е годы. Популярный драматург обвиняется в антисоветчине: спектакль по его пьесе отменяют, а самого его выгоняют из союза литераторов. В не самый лучший момент своей жизни он встречает глубоко несчастную в браке красавицу Маргариту и начинает новый роман, героями которого становятся люди из его окружения, в том числе — мистический персонаж Воланд, списанный со знакомого иностранца.');
