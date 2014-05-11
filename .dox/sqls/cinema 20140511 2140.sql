-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.1.166.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 11.05.2014 21:40:41
-- Версия сервера: 5.6.15-log
-- Версия клиента: 4.1

-- 
-- Отключение внешних ключей
-- 
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;

-- 
-- Установить режим SQL (SQL mode)
-- 
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- 
-- Установка кодировки, с использованием которой клиент будет посылать запросы на сервер
--
SET NAMES 'utf8';

-- 
-- Установка базы данных по умолчанию
--
USE cinema;

--
-- Описание для таблицы cinema
--
DROP TABLE IF EXISTS cinema;
CREATE TABLE cinema (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 8
AVG_ROW_LENGTH = 2730
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'список кинотеатров';

--
-- Описание для таблицы halls
--
DROP TABLE IF EXISTS halls;
CREATE TABLE halls (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  cinema_id INT(11) UNSIGNED NOT NULL,
  seats_amount SMALLINT(5) UNSIGNED DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_halls_cinema_id FOREIGN KEY (cinema_id)
    REFERENCES cinema(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 10
AVG_ROW_LENGTH = 2048
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Кинозалы';

--
-- Описание для таблицы movies
--
DROP TABLE IF EXISTS movies;
CREATE TABLE movies (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(50) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 33
AVG_ROW_LENGTH = 910
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Кинофильмы';

--
-- Описание для таблицы user
--
DROP TABLE IF EXISTS user;
CREATE TABLE user (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  username VARCHAR(40) NOT NULL,
  PRIMARY KEY (id)
)
ENGINE = INNODB
AUTO_INCREMENT = 12
AVG_ROW_LENGTH = 1820
CHARACTER SET cp1251
COLLATE cp1251_general_ci;

--
-- Описание для таблицы seances
--
DROP TABLE IF EXISTS seances;
CREATE TABLE seances (
  id INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  movies_id INT(11) UNSIGNED NOT NULL,
  halls_id INT(10) UNSIGNED NOT NULL,
  showtime TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  free_seats_numbers SMALLINT(5) UNSIGNED DEFAULT 0,
  datetime DATETIME NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_seances_halls_id FOREIGN KEY (halls_id)
    REFERENCES halls(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT FK_seances_movies_id FOREIGN KEY (movies_id)
    REFERENCES movies(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 40
AVG_ROW_LENGTH = 1024
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Киносеансы';

--
-- Описание для таблицы tickets
--
DROP TABLE IF EXISTS tickets;
CREATE TABLE tickets (
  id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  user_id INT(10) UNSIGNED NOT NULL,
  seats VARCHAR(255) NOT NULL,
  seance_id INT(11) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT FK_tickets_user_id FOREIGN KEY (user_id)
    REFERENCES user(id) ON DELETE CASCADE ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 32
AVG_ROW_LENGTH = 16384
CHARACTER SET utf8
COLLATE utf8_general_ci
COMMENT = 'Заказанные билеты';

-- 
-- Вывод данных для таблицы cinema
--
INSERT INTO cinema VALUES
(1, 'Родина'),
(2, 'Космос'),
(3, 'Голубой огонёк'),
(4, 'Круглосуточный'),
(6, 'Упадочный'),
(7, 'Пустозвонковый');

-- 
-- Вывод данных для таблицы halls
--
INSERT INTO halls VALUES
(1, 'Фиолетовый', 1, 300),
(2, 'Голубой', 1, 460),
(4, 'Элитный', 3, 50),
(5, 'Кассиопея', 2, 400),
(6, 'Юпитер', 2, 1900),
(7, 'Близнецы', 2, 800),
(8, 'Galaxy', 2, 1000),
(9, 'Предзакатный', 4, 299);

-- 
-- Вывод данных для таблицы movies
--
INSERT INTO movies VALUES
(1, 'Кто подставил кролика Роджера?'),
(2, 'Хороший, плохой, злой'),
(3, 'Отроки во Вселенной'),
(4, '2001: Космическая Одиссея'),
(5, 'Заводной апельсин'),
(7, 'Большой Лебовски'),
(8, 'По прочтении - сжечь!'),
(9, 'Она'),
(10, 'Полёт над гнездом кукушки'),
(11, 'Лолита'),
(12, 'С широко закрытыми глазами'),
(15, '01 Бессмысленный, беспощадный'),
(17, 'Заблудившийся автобус'),
(18, 'Матрица: предыстория'),
(20, 'Новый поход чувака'),
(21, 'Бунт и праздник'),
(23, 'Пианистка'),
(24, 'Похороните его за плинтусом. Спасибо.'),
(26, '13-й этаж'),
(27, 'Быть Джоном Малковичем'),
(28, 'Армагеддец'),
(29, 'Апокалипсис'),
(30, 'Прогулки с динозаврами'),
(31, '1000000 лет до нашей эры'),
(32, 'Амели');

-- 
-- Вывод данных для таблицы user
--
INSERT INTO user VALUES
(1, 'Default User'),
(2, 'Василий'),
(3, 'Алиса'),
(5, 'Матвей'),
(7, 'Анатоль'),
(8, 'Борислав'),
(9, 'Сара'),
(10, 'Марфа Петровна'),
(11, 'Эрнст Неизвестный');

-- 
-- Вывод данных для таблицы seances
--
INSERT INTO seances VALUES
(22, 15, 4, '2014-05-17 18:40:46', 31, '2014-05-09 09:53:21'),
(23, 4, 6, '2014-05-13 17:58:53', 1895, '2014-05-09 13:40:25'),
(24, 7, 4, '2014-05-11 20:05:35', 45, '2014-05-09 13:40:52'),
(25, 21, 5, '2014-05-11 19:51:51', 396, '2014-05-09 13:41:33'),
(26, 17, 7, '2014-05-11 19:31:47', 790, '2014-05-09 13:42:03'),
(27, 5, 1, '2014-05-15 00:50:11', 290, '2014-05-09 13:42:19'),
(28, 4, 6, '2014-05-14 15:20:55', 1900, '2014-05-09 13:43:04'),
(29, 7, 1, '2014-05-11 20:41:06', 296, '2014-05-09 13:43:41'),
(30, 1, 2, '2014-05-11 20:03:08', 456, '2014-05-09 13:44:11'),
(31, 11, 4, '2014-05-11 08:50:00', 25, '2014-05-09 13:44:32'),
(32, 15, 5, '2014-05-11 20:42:50', 382, '2014-05-09 13:50:36'),
(33, 4, 9, '2014-05-11 19:50:00', 290, '2014-05-09 13:50:55'),
(34, 10, 9, '2014-05-11 20:33:48', 295, '0000-00-00 00:00:00'),
(35, 9, 5, '2014-05-11 19:52:53', 397, '2014-05-09 15:04:09'),
(37, 15, 5, '2014-05-14 18:42:59', 394, '2014-05-09 15:09:20'),
(38, 17, 6, '2014-05-11 20:37:16', 1896, '2014-05-09 15:17:50'),
(39, 12, 2, '2014-05-13 09:10:00', 460, '2014-05-09 15:20:27');

-- 
-- Вывод данных для таблицы tickets
--
INSERT INTO tickets VALUES
(8, 8, '1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25', 31),
(9, 8, '4,5,6,7,8', 23),
(10, 7, '1,2,3,4,11,12,13,14,21,22,23,24', 32),
(12, 9, '10,20,30,40,50,60,70,80,90,100', 27),
(14, 1, '3,12,15,16,19,21,27,38,43,44,48', 22),
(19, 3, '31,32,36,37,41,42,46,47', 22),
(20, 3, '1,2,3,11,12,13', 37),
(22, 10, '1,2,3,4,5,11,12,13,14,15', 26),
(23, 10, '88,102,142,159', 34),
(24, 10, '10,20,30,40,50,60,70,80,90', 33),
(25, 10, '390,391,392,400', 25),
(26, 10, '239,248,257', 35),
(27, 10, '4,26,96,114', 30),
(28, 10, '15,19,25,29,35', 24),
(29, 10, '10,20,30,40', 38),
(30, 10, '39,44,96,131', 29),
(31, 3, '5,16,27,38,49,60', 32);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;