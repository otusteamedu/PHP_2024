INSERT INTO public.type (id, name) VALUES (1, 'text');
INSERT INTO public.type (id, name) VALUES (2, 'int');
INSERT INTO public.type (id, name) VALUES (3, 'date');
INSERT INTO public.type (id, name) VALUES (4, 'time');
INSERT INTO public.type (id, name) VALUES (5, 'bool');

INSERT INTO public.attribute (id, type_id, name) VALUES (1, 1, 'Description');
INSERT INTO public.attribute (id, type_id, name) VALUES (2, 2, 'Duration');
INSERT INTO public.attribute (id, type_id, name) VALUES (3, 3, 'World premiere date');
INSERT INTO public.attribute (id, type_id, name) VALUES (4, 3, 'Russia premiere date');
INSERT INTO public.attribute (id, type_id, name) VALUES (5, 5, 'Oscar');
INSERT INTO public.attribute (id, type_id, name) VALUES (7, 3, 'ticket sales start date');
INSERT INTO public.attribute (id, type_id, name) VALUES (8, 3, 'advertising start date');
INSERT INTO public.attribute (id, type_id, name) VALUES (9, 1, 'critic review');
INSERT INTO public.attribute (id, type_id, name) VALUES (10, 1, 'film academy review');
INSERT INTO public.attribute (id, type_id, name) VALUES (6, 5, 'Золотой орел');

INSERT INTO public.movie (id, name) VALUES (1, 'Титаник');
INSERT INTO public.movie (id, name) VALUES (2, 'Гравитация');
INSERT INTO public.movie (id, name) VALUES (3, 'Движение вверх');
INSERT INTO public.movie (id, name) VALUES (4, 'Чемпион мира');
INSERT INTO public.movie (id, name) VALUES (5, 'Территория зла');

INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (12, 3, 1, e'Есть победы, которые меняют ход истории. Победы духа, победы страны, победы всего мира. Таким триумфом стали легендарные «три секунды» - выигрыш сборной СССР по баскетболу на роковой мюнхенской Олимпиаде 1972 г. Впервые за 36 лет была повержена «непобедимая» команда США. Никто даже помыслить не мог о том, что это возможно – обыграть великолепных непогрешимых американцев на Олимпийских играх! Никто, кроме советских баскетболистов (русских и грузин, украинцев и казахов, белорусов и литовцев).

Когда проигрыш означал поражение страны, когда нужно было выходить и бороться в раскаленной обстановке из-за произошедшего теракта, великий тренер сборной СССР был готов на все, лишь бы помочь своим подопечным разбить американский миф о непотопляемой команде мечты. Ведь он знал, что создал самую сильную сборную на планете, и в начале заставил поверить в это своих игроков, а затем весь мир.', null, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (13, 3, 2, null, 133, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (2, 1, 2, null, 194, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (8, 2, 2, null, 90, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (21, 5, 2, null, 113, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (18, 4, 2, null, 145, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (23, 5, 4, null, null, '2024-03-21', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (3, 1, 3, null, null, '1997-11-01', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (22, 5, 3, null, null, '2024-01-25', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (14, 3, 3, null, null, '2018-01-05', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (9, 2, 3, null, null, '2013-08-28', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (4, 1, 4, null, null, '1998-02-20', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (20, 4, 4, null, null, '2021-12-30', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (10, 2, 4, null, null, '2014-02-21', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (15, 3, 4, null, null, '2018-05-17', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (11, 2, 5, null, null, null, null, true, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (19, 4, 6, null, null, null, null, true, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (16, 3, 6, null, null, null, null, true, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (6, 1, 5, null, null, null, null, true, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (24, 5, 7, null, null, '2024-03-24', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (25, 5, 8, null, null, '2024-04-13', null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (7, 2, 1, e'Доктор Райан Стоун, блестящий специалист в области медицинского инжиниринга, отправляется в свою первую космическую миссию под командованием ветерана астронавтики Мэтта Ковальски, для которого этот полет - последний перед отставкой. Но во время, казалось бы, рутинной работы за бортом случается катастрофа.

Шаттл уничтожен, а Стоун и Ковальски остаются совершенно одни; они находятся в связке друг с другом, и все, что они могут, - это двигаться по орбите в абсолютно черном пространстве без всякой связи с Землей и какой-либо надежды на спасение.', null, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (1, 1, 1, 'В первом и последнем плавании шикарного «Титаника» встречаются двое. Пассажир нижней палубы Джек выиграл билет в карты, а богатая наследница Роза отправляется в Америку, чтобы выйти замуж по расчёту. Чувства молодых людей только успевают расцвести, и даже не классовые различия создадут испытания влюблённым, а айсберг, вставший на пути считавшегося непотопляемым лайнера.', null, null, null, null, null);
INSERT INTO public.value (id, movie_id, attribute_id, text_value, int_value, date_value, time_value, bool_value, float_value) VALUES (17, 4, 1, 'История матча за звание чемпиона мира, который прошел на Филиппинах в 1978 году, между действующим чемпионом Анатолием Карповым и претендентом на этот титул — гроссмейстером Виктором Корчным, несколько лет назад эмигрировавшим из СССР.', null, null, null, null, null);
