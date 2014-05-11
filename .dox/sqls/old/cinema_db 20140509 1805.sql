-- Скрипт сгенерирован Devart dbForge Studio for MySQL, Версия 6.1.166.0
-- Домашняя страница продукта: http://www.devart.com/ru/dbforge/mysql/studio
-- Дата скрипта: 09.05.2014 18:05:07
-- Версия сервера: 5.1.40-community
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
AUTO_INCREMENT = 26
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
AUTO_INCREMENT = 2
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
(25, '22,23,24,50');

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
(22, 15, 4, '2014-05-09 15:20:55', 50, '2014-05-09 09:53:21'),
(23, 4, 6, '2014-05-09 15:20:55', 1900, '2014-05-09 13:40:25'),
(24, 7, 4, '2014-05-09 15:20:55', 50, '2014-05-09 13:40:52'),
(25, 21, 5, '2014-05-09 15:20:55', 400, '2014-05-09 13:41:33'),
(26, 17, 7, '2014-05-09 15:20:55', 800, '2014-05-09 13:42:03'),
(27, 5, 1, '2014-05-09 15:20:55', 300, '2014-05-09 13:42:19'),
(28, 4, 6, '2014-05-09 15:20:55', 1900, '2014-05-09 13:43:04'),
(29, 7, 1, '2014-05-09 15:20:55', 300, '2014-05-09 13:43:41'),
(30, 1, 2, '2014-05-09 15:20:55', 460, '2014-05-09 13:44:11'),
(31, 11, 4, '2014-05-09 15:20:55', 50, '2014-05-09 13:44:32'),
(32, 15, 5, '2014-05-09 15:20:55', 400, '2014-05-09 13:50:36'),
(33, 4, 9, '2014-05-09 15:20:55', 299, '2014-05-09 13:50:55'),
(34, 10, 9, '2014-05-09 15:02:51', 299, '0000-00-00 00:00:00'),
(35, 9, 5, '2014-05-09 15:20:55', 400, '2014-05-09 15:04:09'),
(36, 25, 9, '2014-05-09 15:20:55', 299, '2014-05-09 15:08:48'),
(37, 15, 5, '2014-05-09 15:20:55', 400, '2014-05-09 15:09:20'),
(38, 17, 6, '2014-05-08 10:10:00', 1900, '2014-05-09 15:17:50'),
(39, 12, 2, '2014-05-09 09:10:00', 460, '2014-05-09 15:20:27');

-- 
-- Вывод данных для таблицы tickets
--
INSERT INTO tickets VALUES
(1, 1, '20,22,34,36', 4);

-- 
-- Восстановить предыдущий режим SQL (SQL mode)
-- 
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;

-- 
-- Включение внешних ключей
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;