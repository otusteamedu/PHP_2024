CREATE TABLE `cinema_halls` (
	`id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`num_seats` INT(11) NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
);

CREATE TABLE `cinema_films` (
	`id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	`title` VARCHAR(100) NOT NULL COLLATE 'utf8mb4_general_ci',
	`num_stars` FLOAT NOT NULL DEFAULT '0',
	PRIMARY KEY (`id`) USING BTREE
);

CREATE TABLE `cinema_sessions` (
	`id` INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
	`id_hall` INT(5) UNSIGNED NOT NULL,
	`date` DATE NOT NULL,
	`begintime` TIME NOT NULL,
	`endtime` TIME NOT NULL,
	`id_film` INT(5) UNSIGNED NOT NULL,
	PRIMARY KEY (`id`) USING BTREE,
	INDEX `cinema_sessions_id_hall_foreign` (`id_hall`) USING BTREE,
	INDEX `cinema_sessions_id_film_foreign` (`id_film`) USING BTREE,
	CONSTRAINT `cinema_sessions_id_film_foreign` FOREIGN KEY (`id_film`) REFERENCES `cinema_films` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT,
	CONSTRAINT `cinema_sessions_id_hall_foreign` FOREIGN KEY (`id_hall`) REFERENCES `cinema_halls` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT
)

CREATE TABLE `cinema_prices` (
	`id_hall` INT(5) UNSIGNED NOT NULL,
	`begin_time` TIME NULL DEFAULT NULL,
	`begin_num_seat` INT(11) NULL DEFAULT '0',
	`price` FLOAT NOT NULL,
	UNIQUE INDEX `id_hall_begin_time_begin_num_seat` (`id_hall`, `begin_time`, `begin_num_seat`) USING BTREE,
	CONSTRAINT `cinema_prices_id_hall_foreign` FOREIGN KEY (`id_hall`) REFERENCES `cinema_halls` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT
)

CREATE TABLE `cinema_tickets` (
	`id_session` INT(5) UNSIGNED NOT NULL,
	`num_seat` INT(11) NOT NULL,
	`price` FLOAT NOT NULL,
	UNIQUE INDEX `id_session_num_seat` (`id_session`, `num_seat`) USING BTREE,
	CONSTRAINT `cinema_tickets_id_session_foreign` FOREIGN KEY (`id_session`) REFERENCES `cinema_sessions` (`id`) ON UPDATE RESTRICT ON DELETE RESTRICT
)